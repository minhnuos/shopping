<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OrderController extends Controller
{
    //
    private $order;
    private $product;
    private $shipping;
    private $orderDetail;

    public function __construct(Order $order, Product $product, Shipping $shipping,OrderDetail $orderDetail)
    {
        $this->order = $order;
        $this->product = $product;
        $this->shipping = $shipping;
        $this->orderDetail = $orderDetail;
    }

    public function index()
    {
        $orders = $this->order->latest()->paginate(10);
        return view('admin.order.index', compact('orders'));
    }

    public function viewDetailOrder(Request $request) // hiển thị chi tiết đơn hàng
    {
        $shipping = $this->shipping->all();
        $order = $this->order->find($request->id);
        $orderDetail = $this->getProductbyOrder($order->id);

        $discount = $order->valueCoupon();

        return view('admin.order.detail', compact('order', 'orderDetail', 'shipping', 'discount'));
    }

    public function printBill(Request $request) // in hóa đơn
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->formatBillHtml($request->order_id));
        return $pdf->stream();
    }
    public function getProductbyOrder($order_id) {  // lấy ra tất cả sản phẩm theo đơn đặt hàng
        $orderDetail = $this->orderDetail->where('order_id',$order_id)->get();
        return $orderDetail;
    }
//    public function getCouponbyOrder($order) {  // lấy ra số tiền được giảm giá.
//        $coupon = $order->coupon;
//        $discount = 0;
//        if ($coupon) {
//            if ($coupon->condition == 1) {
//                $discount = $coupon->number;
//            } else {
//                $discount = $coupon->number * 0.01 * (int)str_replace(',', '', $order->total);
//            }
//        }
//        return $discount;
//    }
    public function formatBillHtml($id) // trả về dạng html của hóa đơn
    {
        $html = '<style> body{ font-family: DejaVu Sans ; }</style>';
        $order = $this->order->find($id);
        $orderDetail = $this->getProductbyOrder($order->id);
        $discount = $this->getCouponbyOrder($order);
        $html .= '<h1 style="text-align: center;">HÓA ĐƠN MUA HÀNG</h1>';
        $html .= '<table>
            <tr>
                <td>Tên khách hàng</td>
                <td>: </td>
                <td> ' . $order->customer->name . '</td>
            </tr>
            <tr>
                <td>Số điện thoại  </td>
                <td>: </td>
                <td> ' . $order->customer->phone . '</td>
            </tr>
            <tr>
                <td>Địa chỉ  </td>
                <td>: </td>
                <td> ' . $order->customer->address . '</td>
            </tr>
        </table>';

        $html .= '<h5 style="text-align: center;">Chi tiết đơn hàng</h5>';
        $html .= '<table border="1" style="width: 100%;">
            <tr>
                <td>Tên sản phẩm</td>
                <td>Giá</td>
                <td>Số lượng</td>
                <td>Tổng tiền</td>
            </tr>
        ';
        foreach ($orderDetail as $item) {
            $html .= '
            <tr>
                <td> ' . $item->product->name . '</td>
                <td>'. number_format(($item->product->price)) .'</td>
                <td>'.$item->quantity.'</td>
                <td>'.number_format( $item->product->price*$item->quantity).'</td>
            </tr>
            ';
        }
        $html .= '</table> <br> <br>';
        $html .= '<table>
            <tr>
                <td>Phí vận chuyển</td>
                <td>: </td>
                <td> + ' . number_format($order->fee_ship) . '</td>
            </tr>
            <tr>
                <td>Giảm giá </td>
                <td>: </td>
                <td> ';
        if($discount == 0) {
            $html .= 0;
        } else {
            $html .= '- ' . number_format($discount);
        }
        $html .= '</td>
            </tr>
            <tr>
                <td>Tổng đơn hàng </td>
                <td>: </td>
                <td> ' . number_format((int) str_replace(',','',$order->total) + $order->fee_ship -$discount)  . '</td>
            </tr>
        </table>';
        return $html;
    }
}
