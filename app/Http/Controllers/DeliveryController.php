<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\FeeShip;
use App\Models\Province;
use App\Models\SubDistrict;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DeliveryController extends Controller
{
    //
    private $province, $district, $subDistrict, $feeShip;

    public function __construct(Province $province, District $district, SubDistrict $subDistrict, FeeShip $feeShip)
    {
        $this->province = $province;
        $this->district = $district;
        $this->subDistrict = $subDistrict;
        $this->feeShip = $feeShip;
    }

    public function index()
    {
        $provinces = $this->province->all();
        $districts = $this->district->all();
        $subDistricts = $this->subDistrict->all();
        $feeShips = $this->feeShip->latest()->paginate(10);
        return view('admin.delivery.index', compact('provinces', 'districts', 'subDistricts', 'feeShips'));
    }

    public function getDelivery(Request $request)
    {
        try {
            $action = $request->action;
            $html = '';
            if ($action == 'province') {
                $data = $this->province->find($request->id)->districts;
                $html .= '<option value="">--chọn quận huyện--</option>';
                foreach ($data as $item) {
                    $html .= '<option value="' . $item->id . ' ">' . $item->name . '</option>';
                }
            } else {
                $data = $this->district->find($request->id)->subDistricts;
                $html .= '<option value="">--chọn xã phường--</option>';
                foreach ($data as $item) {
                    $html .= '<option value="' . $item->id . ' ">' . $item->name . '</option>';
                }
            }
            return response()->json(
                [
                    'message' => true,
                    'html' => $html
                ],
                200);
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json(['message' => false], 500);
        }
    }

    public function getDeliveryAndFeeship(Request $request)
    {
        try {
            $action = $request->action;
            $html = '';
            if ($action == 'province') {
                $data = $this->province->find($request->id)->districts;
                $html .= '<option value="">--chọn quận huyện--</option>';
                foreach ($data as $item) {
                    $html .= '<option value="' . $item->id . ' ">' . $item->name . '</option>';
                }
            } else if($action == 'district'){
                $data = $this->district->find($request->id)->subDistricts;
                $html .= '<option value="">--chọn xã phường--</option>';
                foreach ($data as $item) {
                    $html .= '<option value="' . $item->id . ' ">' . $item->name . '</option>';
                }
            }
            $fee_ship = $this->feeShip->where('province_id',$request->province_id)->
                                        where('district_id',$request->district_id)->
                                        where('sub_district_id',$request->subDistrict_id)->first();
            $ship = 50000;
            if($fee_ship) {
                Session::put('feeShip',$fee_ship);
                $ship = Session::get('feeShip')['feeship'];
            }
            return response()->json(
                [
                    'message' => true,
                    'html' => $html,
                    'fee_ship' => number_format($ship),
                    'total' => number_format((int)str_replace(',', '', Cart::total()) + $ship),
                ],
                200);
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json(['message' => false], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->feeShip->updateOrCreate(
                [
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'sub_district_id' => $request->subDistrict_id
                ],
                ['feeship' => $request->feeShip]
            );
            return response()->json(['message' => true], 200);
        } catch (\Exception $exception) {
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine());
            return response()->json([
                'message' => false
            ], 500);
        }
    }

    public function seleteDelivery()
    {
        $feeShips = $this->feeShip->latest()->paginate(10);
        $data = '<div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Tên Thành phố</th>
                                <th>Tên quận huyện</th>
                                <th>Tên xã phường</th>
                                <th>Phí ship</th>
                            </tr>
                            </thead>
                            <tbody>';
        foreach ($feeShips as $item) {
            $data .= '<tr>
                        <th> '. $item->proivince->name .' </th>
                        <th> ' .$item->district->name .'</th>
                        <th> ';
                            if($item->subDistrict)
                                $data .= $item->subDistrict->name;
                            else {
                                $data .= 'null';
                            }
                        $data .= '</th>
                        <th> '.number_format($item->feeship). '</th>
                    </tr>';
        }
        $data .= '</tbody>
                        </table>
                    </div>';
        $data .= '<div class="table-agile-info">
                        <div class="panel panel-default">
                            <footer class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-7 text-right text-center-xs">' .
                                        $feeShips->links() . '
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </div>';
        return response()->json([
            'data' => $data,
        ], 200);
    }
}
