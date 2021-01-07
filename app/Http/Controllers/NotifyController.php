<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotifyController extends Controller
{
    //
    private $option;
    public function __construct(Option $option)
    {
        $this->option = $option;
    }

    public function index() {

    }
    public function getNumberNotify() {
        try {
            $option = $this->option->where('key','notify')->first();
            $number = ' ';
            if($option->value > 0) {
                $number = $option->value;
            }
            return response()->json([
                'number' => $number
            ],200);
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json([
                'message' => false
            ],500);
        }
    }
    public function setNumberEqual0() {
        try {
            $this->option->where('key','notify')->first()->update(['value'=>0]);

            return response()->json([
               'message' => true
            ],200);
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json([
                'message' => false
            ],500);
        }
    }
}
