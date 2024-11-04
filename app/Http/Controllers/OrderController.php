<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;
use App\Events\OrderPlaced;
use Carbon\Carbon;





class OrderController extends Controller
{
    public function getOrders(Request $request)
    {
        $user = auth()->user();
        // dd(auth()->user());
        $orders = Order::where('user_id', $user->id)->get();
        // return $orders;
        return response()->json($orders, 200);
    }
    public function create(Request $request)
    {

        //   dd($request->all());

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'pickup_location' => 'required|string|max:255',
            'delivery_location' => 'required|string|max:255',
            'size' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'pickup_datetime' => 'required', // Updated format
            'delivery_datetime' => 'required', // Updated format
        ]);
        // Check for validation errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    //   dd($request->all());
        // Create the order

        $pickupDatetime = Carbon::parse($request->pickup_datetime)->format('Y-m-d H:i:s');
    $deliveryDatetime = Carbon::parse($request->delivery_datetime)->format('Y-m-d H:i:s');

        $order = Order::create([
            'user_id' => $request->user()->id, // or however you retrieve the user ID
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location,
            'size' => $request->size,
            'weight' => $request->weight,
            'pickup_datetime' => $pickupDatetime,
            'delivery_datetime' => $deliveryDatetime,
            'status' => 'Pending', // Default status
        ]);
    
        $adminEmail = env('ADMIN_EMAIL');
      
        Notification::route('mail', $adminEmail) 
        ->notify(new NewOrderNotification($order));
        event(new \App\Events\OrderPlaced($order));

        return response()->json(['message' => 'Order created successfully!', 'order' => $order,'status'=>201]);
    }
    public function updateStatus(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|in:Pending,In-Progress,Delivered',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('status', 'Order status updated successfully!'); // Redirect back with a success message
    }

}
