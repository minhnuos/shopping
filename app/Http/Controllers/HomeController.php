<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
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

    public function index()
    {
        $sliders = $this->slider->latest()->get();
        $categoryProducts = $this->categoryProduct->where('status',1)->get();
        $brandProducts = $this->brandProduct->where('status',1)->get();
        $products = $this->product->latest()->limit(3)->get();
        return view('pages.home',compact('categoryProducts' , 'brandProducts','products','sliders'));
    }
}
