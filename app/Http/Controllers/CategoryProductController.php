<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CategoryProductController extends Controller
{
    //
    private $categoryProduct,$brandProduct,$slider;
    public function __construct(CategoryProduct $categoryProduct,BrandProduct $brandProduct,Slider $slider)
    {
        $this->categoryProduct = $categoryProduct;
        $this->brandProduct = $brandProduct;
        $this->slider = $slider;
    }

//    function admin
    public function index() {
        $category_product = $this->categoryProduct->all();
        return view('admin.categoryProduct.index',compact('category_product'));
    }
    public function create() {
        return view('admin.categoryProduct.create');
    }
    public function store(Request $request) {
        try {
            $this->categoryProduct->create([
                'name' => $request->name,
                'desc' => $request->desc,
                'status' => $request->status,
                'slug' => Str::slug($request->name),
            ]);
            Session::put('message', 'thêm danh mục sản phẩm thành công');
            return redirect()->route('index.category.product');
        } catch (\Exception $exception) {
            Log::error('lỗi ' . $exception->getMessage() . ' ở dòng ' . $exception->getLine());
        }

    }
    public function edit(Request $request) {
        $category_product = $this->categoryProduct->find($request->id);
        return view('admin.categoryProduct.edit',compact('category_product'));
    }
    public function update(Request $request) {
        try {
            $this->categoryProduct->find($request->id)->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'slug' => Str::slug($request->name),
            ]);
            Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
            return redirect()->route('index.category.product');
        } catch (\Exception $exception) {
            Log::error('lỗi ' . $exception->getMessage() . ' ở dòng ' . $exception->getLine());
        }
    }
    public function delete(Request $request) {
        $this->categoryProduct->find($request->id)->delete();
        Session::put('message','xóa danh mục sản phẩm thành công!');
        return redirect()->route('index.category.product');
    }

    public function unactive(Request $request) {
        $this->categoryProduct->find($request->id)->update(['status' => 1]);
        Session::put('message','Hủy kích hoạt danh mục thành công!');
        return redirect()->route('index.category.product');
    }
    public function active(Request $request) {
        $this->categoryProduct->find($request->id)->update(['status' => 0]);
        Session::put('message','Kích hoạt danh mục thành công!');
        return redirect()->route('index.category.product');
    }


//    function user
    public function getAllProductByCategory(Request $request) {
        $sliders = $this->slider->latest()->get();
        $category = $this->categoryProduct->where('slug',$request->slug)->first();
        $categoryProducts = $this->categoryProduct->where('status',1)->get();
        $brandProducts = $this->brandProduct->where('status',1)->get();
        return view('pages.category.index', compact('category','categoryProducts','brandProducts','sliders'));
    }

}
