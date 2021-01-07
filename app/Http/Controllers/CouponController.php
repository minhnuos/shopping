<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    //
    private $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function index()
    {
        $coupons = $this->coupon->latest()->paginate(10);
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(Request $request)
    {
        try {
            $this->coupon->create([
                'name' => $request->name,
                'code' => $request->code,
                'quantity' => $request->qty,
                'time' => $request->time,
                'condition' => $request->addition,
                'number' => $request->number
            ]);
            return redirect()->route('index.coupon');
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
        }
    }

    public function checkCoupon(Request $request)
    {
        try {
            $coupon = $this->coupon->where('code', $request->codeCoupon)->first();
            if (!empty($coupon)) {
                if($coupon->quantity == 0) {
                    return response()->json(['message' => false], 408);
                } else {
                    if ($coupon->condition == 1) {
                        $discountRate = $coupon->number;
                    } else {
                        $discountRate = (((int)str_replace(',', '', Cart::priceTotal())) * ($coupon->number * 0.01));
                    }
                    Session::put('coupon', ['discountRate' => $discountRate, 'id' => $coupon->id]);
                    $ship = 0;
                    if (Session::get('feeShip')) {
                        $ship = Session::get('feeShip')['feeship'];
                    }
                    return response()->json([
                        'message' => true,
                        'discountRate' => '- ' . number_format(Session::get('coupon')['discountRate']),
                        'total' => number_format((int)str_replace(',', '', Cart::total()) - $discountRate + $ship)

                    ], 200);
                }
            }
            return response()->json(['message' => false], 409);
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json(['message' => false], 500);
        }
    }

    public function deleteCoupon(Request $request)
    {
        try {
            Session::forget('coupon');
            $ship = 0;
            if(Session::get('feeShip')) {
                $ship = Session::get('feeShip')['feeship'];
            }
            return response()->json([
                'message' => true,
                'discountRate' => 0,
                'total' =>  number_format((int)str_replace(',', '', Cart::total())  + $ship)

            ], 200);
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json(['message' => false], 500);
        }
    }
}
