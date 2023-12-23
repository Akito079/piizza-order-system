<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct order list page
    public function orderList()
    {
        $order = Order::when(request('key'), function ($query) {
                $query->orWhere('orders.order_code', 'like', '%' . request('key') . '%')
                ->orWhere('users.name', 'like', '%' . request('key') . '%');
                })->select('orders.*', 'users.name as user_name')
                ->orderBy('created_at', 'desc')
                ->leftJoin('users', 'users.id', 'orders.user_id')
                ->get();
        return view('admin.order.list', compact('order'));
    }
    //filter order status
    public function orderStatus(Request $request)
    {
        // $request->status = $request->status == null ? "" : $request->status;
        // ->orWhere('orders.status',$request->status)
        // ->get();
        $order = Order::when(request('key'), function ($query) {
                $query->orWhere('orders.order_code', 'like', '%' . request('key') . '%')
                ->orWhere('users.name', 'like', '%' . request('key') . '%');
                })->select('orders.*', 'users.name as user_name')
                ->orderBy('created_at', 'desc')
                ->leftJoin('users', 'users.id', 'orders.user_id');
        if ($request->status == null) {
            $order = $order->get();
        } else {
            $order = $order->where('orders.status', $request->status)->get();
        }

        return response()->json($order, 200);
    }
    //Change status
    public function changeStatus(Request $request)
    {
        Order::where('id', $request->orderId)->update([
            'status' => $request->status,
        ]);
        $response =[
            'message' => 'success',
        ];
        return response()->json($response,200);
    }

    //list info
    public function listInfo ($orderCode){
        $order = Order::where('order_code',$orderCode)->first();
        $orderList = OrderList::select('order_lists.*','users.name as user_name','products.name as product_name','products.image as product_image')
                    ->leftJoin('users','users.id','order_lists.user_id')
                    ->leftJoin('products','products.id','order_lists.product_id')
                    ->where('order_code',$orderCode)
                    ->get();
        // dd($orderList->toArray());
      return view('admin.order.productList',compact('orderList','order'));
    }
}
