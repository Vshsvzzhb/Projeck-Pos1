<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use App\Models\Member;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index', [
            'categories' => Category::all(),
            'member'     => Member::all(),
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        // validate incoming request
        $validated = $request->validate([
            'customer_id'   => 'required|exists:members,id',
            'order_payload' => 'required|string',
        ]);

        $payload = json_decode($validated['order_payload'], true);
        if (!$payload || empty($payload['items'])) {
            return redirect()->back()->with('error', 'No Items In Order');
        }

        DB::beginTransaction();

        try {
            // create order
            $order = new Order();
            $order->invoice     = 'INV' . time();
            $order->total       = $payload['total'] ?? array_sum(array_column($payload['items'], 'price'));
            $order->user_id     = Auth::id() ?? 1;
            $order->customer_id = $validated['customer_id'];
            $order->save();

            // create order details
            foreach ($payload['items'] as $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['qty'],
                    'price'      => $item['price'], // total price per item (qty * unitPrice)
                ]);
            }

            DB::commit();

            return response()->json([
                'success'   => true,
                'print_url' => route('order.print', $order->id),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print(Order $order)
    {
        $details = OrderDetail::where('order_id', $order->id)->get();

        // get all products used
        $productIds = $details->pluck('product_id')->unique()->toArray();
        $products   = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');

        return view('order.print', [
            'order'    => $order,
            'details'  => $details,
            'products' => $products,
        ]);
    }
}
