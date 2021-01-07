<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Slider;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    //
    private $categoryProduct,$brandProduct,$product,$slider;
    public function __construct(CategoryProduct $categoryProduct, BrandProduct $brandProduct, Product $product,Slider $slider)
    {
        $this->categoryProduct = $categoryProduct;
        $this->brandProduct = $brandProduct;
        $this->product = $product;
        $this->slider = $slider;
    }

    public function index() {
        $cart = Cart::content();
        $sliders = $this->slider->latest()->get();
        $categoryProducts = $this->categoryProduct->where('status',1)->get();
        $brandProducts = $this->brandProduct->where('status',1)->get();
        return view('pages.cart.index',compact('categoryProducts','brandProducts','cart','sliders'));
    }
    public function addProductToCart(Request $request) {
        try {
            $product = $this->product->find($request->product_id);
            if($product->quantity > 0) {
                $data = [
                    'id' => $product->id,
                    'qty'=> $request->quantity,
                    'name' => $product->name,
                    'price' => $product->price,
                    'weight' => $request->quantity,
                    'options' => [
                        'image' =>  $product->image
                    ],
                ];
                Cart::add($data);
                return response()->json([
                    'message' => true,
                ],200);
            }  else {
                return response()->json([
                    'message' => true,
                ],400);
            }

        } catch (\Exception $exception) {
            Log::error('Error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json([
                'message' => false,
            ],500);
        }
    }
    public function deleteProductToCart(Request $request) {
        try {
            Cart::remove($request->rowId);
            $cartTotal = Cart::total();
            $cartTax = Cart::tax();
            $cartSubTotal = Cart::subtotal();

            return response()->json([
                'message' => true,
                'total' => $cartTotal,
                'tax' => $cartTax,
                'subtotal' => $cartSubTotal,
            ],200);
        } catch (\Exception $exception) {
            Log::error('Error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json([
                'message' => false,
            ],500);
        }
    }
    public function updateProductToCart(Request $request) {
        try {
            $cartItem = Cart::get($request->rowId);
            $product = $this->product->find($cartItem->id);
            if($request->qty > $product->quantity) {
                return response()->json([

                ],400);
            } else {
                Cart::update($request->rowId, $request->qty);
                $cartTotal = Cart::total();
                $cartTax = Cart::tax();
                $cartSubTotal = Cart::subtotal();

                return response()->json([
                    'message' => true,
                    'total' => $cartTotal,
                    'tax' => $cartTax,
                    'subtotal' => $cartSubTotal,
                    'totalCartItem' => number_format($cartItem->qty * $cartItem->price),

                ], 200);
            }
        } catch (\Exception $exception) {
            Log::error('Error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json([
                'message' => false,
            ],500);
        }
    }
}
