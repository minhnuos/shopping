<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    //
    private $slider;
    use UploadFile;
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function index() {
        $sliders = $this->slider->latest()->paginate(5);
        return view('admin.slider.index',compact('sliders'));
    }
    public function create() {
        return view('admin.slider.create');
    }
    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $path = $this->uploadFile('slider','image',$request);
            $this->slider->create([
                'name' => $request->name,
                'image' => $path,
                'desc' => $request->desc,
                'status' => $request->status
            ]);
            DB::commit();
            return redirect()->route('index.slider');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
        }
    }
}
