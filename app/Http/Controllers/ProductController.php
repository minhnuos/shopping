<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Slider;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    //
    use UploadFile;
    private $product;
    private $categoryProduct;
    private $brandProduct,$slider;
    public function __construct(Product $product, CategoryProduct $categoryProduct,BrandProduct $brandProduct,Slider $slider)
    {
        $this->product = $product;
        $this->categoryProduct = $categoryProduct;
        $this->brandProduct = $brandProduct;
        $this->slider = $slider;
    }

    public function index() {
        $products = $this->product->latest()->paginate(5);
        return view('admin.product.index',compact('products'));
    }
    public function create() {
        $categoryProducts = $this->categoryProduct->all();
        $brandProducts = $this->brandProduct->all();
        return view('admin.product.create',compact('categoryProducts','brandProducts'));
    }
    public function store(Request $request) {
        try {
            $pathImage = $this->uploadFile('product','image', $request);
            $this->product->create([
                'name' => $request->name,
                'price' => $request->price,
                'desc' => $request->desc,
                'status' => $request->status,
                'content' => $request->contents,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'slug' => Str::slug($request->name),
                'image' => $pathImage,
            ]);
            Session::put('message', 'thêm sản phẩm thành công');
            return redirect()->route('index.product');
        } catch (\Exception $exception) {
            Log::error('lỗi ' . $exception->getMessage() . ' ở dòng ' . $exception->getLine());
        }

    }
    public function edit(Request $request) {
        $product = $this->product->find($request->id);
        $categoryProducts = $this->categoryProduct->all();
        $brandProducts = $this->brandProduct->all();
        return view('admin.product.edit',compact('product','categoryProducts','brandProducts'));
    }
    public function update(Request $request) {
        try {
            $productUpdate = [
                'name' => $request->name,
                'price' => $request->price,
                'desc' => $request->desc,
                'content' => $request->contents,
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->name),
                'brand_id' => $request->brand_id,
            ];
            if($request->hasFile('image')) {
                $pathImage = $this->uploadFile('product','image', $request);
                $productUpdate['image'] = $pathImage;
            }

            $this->product->find($request->id)->update($productUpdate);
            Session::put('message', 'Cập nhật  sản phẩm thành công');
            return redirect()->route('index.product');
        } catch (\Exception $exception) {
            Log::error('lỗi ' . $exception->getMessage() . ' ở dòng ' . $exception->getLine());
        }
    }
    public function delete(Request $request) {
        $this->product->find($request->id)->delete();
        Session::put('message','xóa  sản phẩm thành công!');
        return redirect()->route('index.product');
    }

    public function unactive(Request $request) {
        $this->product->find($request->id)->update(['status' => 1]);
        Session::put('message','Hủy kích hoạt thành công!');
        return redirect()->route('index.product');
    }
    public function active(Request $request) {
        $this->product->find($request->id)->update(['status' => 0]);
        Session::put('message','Kích hoạt thành công!');
        return redirect()->route('index.product');
    }

    public function showProductDetail(Request $request) {
        $sliders = $this->slider->latest()->get();
        $categoryProducts = $this->categoryProduct->where('status',1)->get();
        $brandProducts = $this->brandProduct->where('status',1)->get();
        $product = $this->product->where('slug',$request->slug)->first();
        $recommentProduct = $this->product
                            ->where('category_id',$this->product->where('slug',$request->slug)->first()->category_id)
                            ->where('slug', '!=' , $request->slug)->limit(6)->get();
        return view('pages.product.product_detail',
            compact('categoryProducts' , 'brandProducts','product','recommentProduct','sliders'));
    }
}
