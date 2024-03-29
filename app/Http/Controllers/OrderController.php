<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->input("user_id");
        $orders = Order::query();

        $orders->when($userId, function ($query) use ($userId) {
            return $query->where('user_id', '=', $userId);
        });

        $data = $orders->get();
        // $metadata = json_encode($data['metadata']);
        // $data['metadata'] = $metadata;

        foreach ($data as $dat) {
            $metadata = json_decode($dat['metadata']);
            $dat['metadata'] = $metadata;
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->input('user');
        $course = $request->input('course');

        $order = Order::create([
            'user_id' => $user['id'],
            'course_id' => $course['id'],
        ]);

        $transactionDetails = [
            'order_id' => $order->id . '-' . Str::random(5),
            'gross_amount' => $course['price'],
        ];

        $itemDetails = [
            [
                'id' => $course['id'],
                'price' => $course['price'],
                'quantity' => 1,
                'name' => $course['name'],
                'brand' => 'Esploor',
                'category' => 'Onlne Course'
            ],
        ];

        $customerDetails = [
            'first_name' => $user['name'],
            'email' => $user['email'],
        ];

        $midtransParams = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        $midtransSnapUrl = $this->getMidtransSnapUrl($midtransParams);

        $order->snap_url = $midtransSnapUrl;
        $order->metadata = [
            'course_id' => $course['id'],
            'course_price' => $course['price'],
            'course_name' => $course['name'],
            'course_thumbnail' => $course['thumbnail'],
            'level' => $course['level'],
        ];

        $order->save();

        return response()->json([
            'status' => 'success',
            'data' => $order,
        ]);
    }

    private function getMidtransSnapUrl($params)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_PRODUCTION');
        \Midtrans\Config::$is3ds = (bool) env('MIDTRANS_3DS');

        $snapUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        return $snapUrl;
    }
}
