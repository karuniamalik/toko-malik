<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
  public function index(){

    $transactions = Transaction_detail::with(['transaction.user','product.galleries'])
   ->whereHas('product',function($product){
    $product->where('users_id', Auth::user()->id);
   });

   $revenue = $transactions->get()->reduce(function($carry, $item){
    return $carry + $item->price;
   });

   $customer = User::count();

    return view('pages.dashboard',[
      'transaction_count' => $transactions->count(),
      'transaction_data' => $transactions->get(),
      'revenue' => $revenue,
      'customer' => $customer
    ]);
  }
}
