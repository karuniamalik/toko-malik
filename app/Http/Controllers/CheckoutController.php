<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Transaction;
use App\Transaction_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Notification;

use Exception;

use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    //
    public function process(Request $request){

        // save users data
        $user = Auth::user();
        $user->update($request->except('total_price'));
        
        // proses checkout
        $code = 'STORE-' . mt_rand(0000,9999);
        $carts = Cart::with(['product','user'])
                    ->where('users_id',Auth::user()->id)
                    ->get();
        
        // transaction create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'inscurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code
        ]);

        // transaction detail

            foreach ($carts as $cart) {
                # code...
                $trx = 'TRX-' . mt_rand(000000,999999);
                    Transaction_detail::create([
                    'transactions_id' => $transaction->id,
                    'products_id' => $cart->product->id,
                    'price' => $cart->product->price,
                    'shipping_status' => 'PENDING',
                    'resi' => '',
                    'code' => $trx
                    ]);
            }
            // return dd($transaction);
            Cart::with(['product','user'])
                           ->where('users_id', Auth::user()->id)
                           ->delete();
            
            // konfigurasi midtrans
            config::$serverKey = config('services.midtrans.serverKey');
            config::$isProduction = config('services.midtrans.isProduction');
            config::$isSanitized = config('services.midtrans.isSanitized');
            config::$is3ds = config('services.midtrans.is3ds');

            // buat array untuk dikirim ke midtrans

            $midtrans = [
                'transaction_details' =>[
                    'order_id' => $code,
                    'gross_amount' => (int) $request->total_price,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'enabled_payments' => [
                    'gopay', 'bank_transfer'
                ],
                'vtweb' => []
            ];

            try{
                $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
                return redirect($paymentUrl);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }

    }

    public function callback(Request $request)
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat instance midtrans notification
        $notification = new Notification();

        // Assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cari transaksi berdasarkan ID
        // $transaction = Transaction::findOrFail($order_id);
        $transaction = Transaction::where('code',$order_id)->first();
        

        // Handle notification status midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaction->transaction_status = 'PENDING';
                }
                else {
                    $transaction->transaction_status = 'SUCCESS';
                }
            }
        }
        else if ($status == 'settlement'){
            $transaction->transaction_status = 'SUCCESS';
        }
        else if($status == 'pending'){
            $transaction->transaction_status = 'PENDING';
        }
        else if ($status == 'deny') {
            $transaction->transaction_status = 'CANCELLED';
        }
        else if ($status == 'expire') {
            $transaction->transaction_status = 'CANCELLED';
        }
        else if ($status == 'cancel') {
            $transaction->transaction_status = 'CANCELLED';
        }

        // Simpan transaksi
        $transaction->save();
    }
}
