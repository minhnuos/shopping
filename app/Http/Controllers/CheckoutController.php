<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\District;
use App\Models\FeeShip;
use App\Models\Option;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Province;
use App\Models\Shipping;
use App\Models\Slider;
use App\Models\SubDistrict;
use App\Models\User;
use App\Notifications\OrderProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Pusher\Pusher;

class CheckoutController extends Controller
{
    //
    private $categoryProduct,$brandProduct,$product,$slider;
    private $shipping, $order, $orderDetail,$payment,$user,$option;
    private $customer,$delivery,$province,$district,$subDistrict,$feeShip,$coupon;
    public function __construct(CategoryProduct $categoryProduct,
                                BrandProduct $brandProduct,
                                Product $product,
                                Shipping $shipping,
                                Order $order,
                                OrderDetail $orderDetail,Payment $payment,
                                Customer $customer, FeeShip $feeShip,
                                Province $province,District $district,
                                SubDistrict $subDistrict,
                                Coupon $coupon,Slider $slider,
                                User $user,Option $option
    )
    {
        $this->categoryProduct = $categoryProduct;
        $this->brandProduct = $brandProduct;
        $this->product = $product;
        $this->shipping = $shipping;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->payment = $payment;
        $this->customer = $customer;
        $this->delivery = $feeShip;
        $this->province = $province;
        $this->district = $district;
        $this->subDistrict = $subDistrict;
        $this->feeShip = $feeShip;
        $this->coupon = $coupon;
        $this->slider = $slider;
        $this->user = $user;
        $this->option = $option;
    }
    public function index() {
        $cart = Cart::content();
        $coupon = Session::get('coupon');
        $provinces = $this->province->all();
        $province = 0;$district= 0;
        $discountRate = 0;
        $customer = $this->customer->where('user_id',Auth::id())->orderBy('id', 'desc')->first();
        $ship = 0;
        if($customer) {
            $province = $this->province->find($customer->province_id);
            $district = $this->district->find($customer->district_id);
            $fee_ship = $this->feeShip->where('province_id',$customer->province_id)->
            where('district_id',$customer->district_id)->
            where('sub_district_id',$customer->sub_district_id)->first();
            if($fee_ship) {
                Session::put('feeShip',$fee_ship);
                $ship = Session::get('feeShip')['feeship'];
            }
        }
        if(!empty($coupon)) {
            $discountRate = $coupon['discountRate'];
        }
        $categoryProducts = $this->categoryProduct->where('status',1)->get();
        $brandProducts = $this->brandProduct->where('status',1)->get();
        $payment = $this->payment->all();
        $sliders = $this->slider->latest()->get();
        return view('pages.checkout.index',compact(
            'categoryProducts',
                'customer','provinces'
            ,'province','district',
            'brandProducts','cart','payment'
            ,'discountRate','ship','sliders'
            )
        );
    }
    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $cart = Cart::content();
            if(count($cart) == 0) {
                return response()->json(['message' => true], 409);
            } else {
                // insert table shipping
                $customer = $this->customer->firstOrCreate([
                    'user_id' => Auth::id(),
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'sub_district_id' => $request->sub_district_id,
                ]);
                // insert table order
                $coupon_id = 0;
                if(Session::get('coupon')) {
                    $coupon_id = Session::get('coupon')['id'];
                }
                $feeShip = 0;
                if(Session::get('feeShip')) {
                    $feeShip = Session::get('feeShip')['feeship'];
                }
                $order = $this->order->create([
                    'payment_id' => $request->payment,
                    'customer_id' => $customer->id,
                    'total' => Cart::total(),
                    'status' => 0,
                    'note' => $request->note,
                    'coupon_id' => $coupon_id,
                    'fee_ship' => $feeShip
                ]);

                // insert table ordetail
                foreach ($cart as $item) {
                    $this->orderDetail->create([
                        'order_id' => $order->id,
                        'product_id' => $item->id,
                        'quantity' => $item->qty
                    ]);
                    // update lại số lượng sản phẩm còn lại
                    $product = $this->product->find($item->id);

                    $this->product->find($item->id)->update(['quantity' => $product->quantity - $item->qty]);
                }
                // reduction coupon
                if($coupon_id != 0) {
                    $coupon = $this->coupon->find($coupon_id);
                    $this->coupon->find($coupon_id)->update(['quantity' => $coupon->quantity - 1]);
                }

                Session::forget(['coupon','feeShip']);

                $data = array(
                    'title' =>  Auth::user()->name,
                    'message' => 'Vừa đặt hàng',
                    'action_id' => 0,
                    'id' => $order->id
                );
                // insert table notify
                $users = $this->user->where('is_admin',1)->get();
                foreach ($users as $user) {
                    $user->notify(new OrderProduct($data));
                }
                // send message order for admin
                $options = array(
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'encrypted' => true
                );
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );
                $pusher->trigger('MessageActionUser', 'send-action-user', $data);
                // end send message
                $option = $this->option->where('key','notify')->first();
                $this->option->where('key','notify')->first()->update(['value' =>$option->value + 1]);
                Cart::destroy();
                DB::commit();
                return response()->json(['message' => true], 200);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json(['message' => false],500);
        }
    }
    public function history() {
        $categoryProducts = $this->categoryProduct->where('status',1)->get();
        $brandProducts = $this->brandProduct->where('status',1)->get();
        $sliders = $this->slider->latest()->get();
        $customers = $this->user->find(Auth::id())->customers;
        $orders =  [];
        foreach ($customers as $item) {
            $orders[] = $item->orders;
        }
        return view('pages.checkout.history',compact('categoryProducts','brandProducts','sliders','orders'));
    }
}
