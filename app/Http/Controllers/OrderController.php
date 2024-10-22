<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        // استرجاع الطلبات مع الخدمات الأساسية والخدمات الفرعية مع نظام الصفحات
        $perPage = 12; // عدد الطلبات في كل صفحة
        $requests = Order::with(['mainService', 'subService'])->paginate($perPage);

        // يمكنك إضافة معلومات أخرى إذا كنت بحاجة لذلك
        return response()->json([
            'current_page' => $requests->currentPage(),
            'last_page' => $requests->lastPage(),
            'total' => $requests->total(),
            'data' => $requests->items(), // الطلبات في الصفحة الحالية
        ]);
    }


    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);
            return response()->json([
                'order' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }



    public function store(Request $request)
    {

        try {
            $validation = Validator::make($request->all(), [
                'phone_number' => 'required|string',
                'main_service' => 'required|string',
                'sub_service' => 'required|string',
                'request_description' => 'required|string',
            ]);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()]);
            }

            $neworder = new Order();

            $neworder->phone_number = $request->phone_number;
            $neworder->main_service = $request->main_service;
            $neworder->sub_service = $request->sub_service;
            $neworder->request_description = $request->request_description;

            $neworder->save();

            return response()->json($neworder, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        // تحقق من صحة الطلب
        $request->validate([
            'order_status' => 'required|string|max:255', // تحقق من أن order_status مطلوب وأنه نص
        ]);

        // ابحث عن الطلب باستخدام المعرف
        $order = Order::find($id);

        // تحقق مما إذا كان الطلب موجودًا
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // تحديث order_status
        $order->order_status = $request->input('order_status');
        $order->save(); // حفظ التغييرات

        return response()->json(['message' => 'Order status updated successfully', 'order' => $order], 200);
    }



    public  function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response()->json([
                'message' => 'Order Deleted Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
