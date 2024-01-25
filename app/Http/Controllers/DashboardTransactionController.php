<?php

namespace App\Http\Controllers;

use App\Transaction_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    //
    public function index(){

        $sellTransactions = Transaction_detail::with(['transaction.user','product.galleries'])
        ->whereHas('product', function($product){
            $product->where('users_id', Auth::user()->id);
        })->get();
        $buyTransactions = Transaction_detail::with(['transaction.user','product.galleries'])
        ->whereHas('transaction', function($transaction){
            $transaction->where('users_id', Auth::user()->id);
        })->get();
        return view('pages.dashboard-transaction',[
            'sellTransactions' => $sellTransactions,
            'buyTransactions' => $buyTransactions
        ]);
    }
    public function details(Request $request, $id){
        $transaction = Transaction_detail::with(['transaction.user','product.galleries'])->findOrFail($id);
        return view('pages.dashboard-transaction-details',[
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, $id ){

        $data = $request->all();
        $item = Transaction_detail::findOrFail($id);
        $item->update($data);
        return redirect()->route('dashboard-transaction-details',$id);
    }
}
