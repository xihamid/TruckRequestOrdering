<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class DashboardController extends Controller
{
    public function index()
{
 
    $user = auth()->user(); 
    $orders = Order::getOrdersWithUsers();

  
    return view('dashboard', [
        'orders' => $orders,
        'user' => $user 
    ]);
}
}
