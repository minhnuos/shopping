<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShippingController extends Controller
{
    //
    private $shipping;
    private $order;
    public function __construct(Shipping $shipping, Order $order)
    {
        $this->shipping = $shipping;
        $this->order = $order;
    }

    public function index() {
        $shipping = $this->shipping->latest()->paginate(10);
        return view('admin.shipping.index',compact('shipping'));
    }
    public function chooseShipping(Request $request) {
        $this->order->find($request->order_id)->update([
            'shipping_id' => $request->shipping_id,
            'status' => 1
        ]);
        return redirect()->route('detail.order',['id' => $request->order_id]);
    }
    public function store(Request $request) {
        try {
            $this->shipping->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            return redirect()->route('index.shipping');
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
        }
    }
}
