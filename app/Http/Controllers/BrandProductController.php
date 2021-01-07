<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BrandProductController extends Controller
{
    //
    private $brandProduct, $categoryProduct,$slider;
    public function __construct(BrandProduct $brandProduct, CategoryProduct $categoryProduct,Slider $slider)
    {
        $this->brandProduct = $brandProduct;
        $this->categoryProduct = $categoryProduct;
        $this->slider = $slider;
    }

//    function amdin

    public function index() {
        $brand_product = $this->brandProduct->all();
        return view('admin.brandProduct.index',compact('brand_product'));
    }
    public function create() {
        return view('admin.brandProduct.create');
    }
    public function store(Request $request) {
        try {
            $this->brandProduct->create([
                'name' => $request->name,
                'desc' => $request->desc,
                'status' => $request->status,
                'slug' => Str::slug($request->name),
            ]);
            Session::put('message', 'thêm thương hiệu sản phẩm thành công');
            return redirect()->route('index.brand.product');
        } catch (\Exception $exception) {
            Log::error('lỗi ' . $exception->getMessage() . ' ở dòng ' . $exception->getLine());
        }

    }
    public function edit(Request $request) {
        $brand_product = $this->brandProduct->find($request->id);
        return view('admin.brandProduct.edit',compact('brand_product'));
    }
    public function update(Request $request) {
        try {
            $this->brandProduct->find($request->id)->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'slug' => Str::slug($request->name),
            ]);
            Session::put('message', 'Cập nhật thương hiệu sản phẩm thành công');
            return redirect()->route('index.brand.product');
        } catch (\Exception $exception) {
            Log::error('lỗi ' . $exception->getMessage() . ' ở dòng ' . $exception->getLine());
        }
    }
    public function delete(Request $request) {
        $this->brandProduct->find($request->id)->delete();
        Session::put('message','xóa thương hiệu sản phẩm thành công!');
        return redirect()->route('index.brand.product');
    }

    public function unactive(Request $request) {
        $this->brandProduct->find($request->id)->update(['status' => 1]);
        Session::put('message','Hủy kích hoạt thương hiệu thành công!');
        return redirect()->route('index.brand.product');
    }
    public function active(Request $request) {
        $this->brandProduct->find($request->id)->update(['status' => 0]);
        Session::put('message','Kích hoạt thương hiệu thành công!');
        return redirect()->route('index.brand.product');
    }

//    function user

    public function getAllProductByBrand(Request $request) {
        $sliders = $this->slider->latest()->get();
        $brand = $this->brandProduct->where('slug',$request->slug)->first();
        $categoryProducts = $this->categoryProduct->where('status',1)->get();
        $brandProducts = $this->brandProduct->where('status',1)->get();
        return view('pages.brand.index', compact('brand','categoryProducts','brandProducts','sliders'));
    }

}
