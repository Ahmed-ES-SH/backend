<?php

namespace App\Http\Controllers;

use App\Services\ImageUploadService;
use App\Models\secend_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SecendSectionController extends Controller
{


    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService; // حقن الـ Service
    }


    public function index(Request $request)
    {
        try {
            // استرجاع جميع النصوص من قاعدة البيانات
            $texts = secend_section::all();

            // التحقق مما إذا كانت هناك نصوص
            if ($texts->isEmpty()) {
                return response()->json(['message' => 'No texts found'], 404);
            }

            return response()->json(['data' => $texts], 200);
        } catch (\Exception $e) {
            // إذا حدث خطأ ما، ارجع رسالة الخطأ مع كود الحالة 500
            return response()->json(['message' => 'Failed to retrieve texts: ' . $e->getMessage()], 500);
        }
    }



    public function updateText(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'text1_ar' => 'sometimes|string',
            'text1_en' => 'sometimes|string',
            'text2_ar' => 'sometimes|string',
            'text2_en' => 'sometimes|string',
            'text3_ar' => 'sometimes|string',
            'text3_en' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // البحث عن النصوص حسب المعرف
        $text = secend_section::findOrFail(1);

        // تحديث النصوص
        if ($request->has('text1_ar')) {
            $text->text1_ar = $request->text1_ar;
        }
        if ($request->has('text1_en')) {
            $text->text1_en = $request->text1_en;
        }
        if ($request->has('text2_ar')) {
            $text->text2_ar = $request->text2_ar;
        }
        if ($request->has('text2_en')) {
            $text->text2_en = $request->text2_en;
        }
        if ($request->has('text3_ar')) {
            $text->text3_ar = $request->text3_ar;
        }
        if ($request->has('text3_en')) {
            $text->text3_en = $request->text3_en;
        }

        // تحديث الصورة إذا تم إرسالها
        if ($request->hasFile('image')) {
            // استخدام الخدمة لرفع الصورة وحذف القديمة
            $this->imageUploadService->uploadImage($request, $text, 'images');
        }

        // حفظ التغييرات
        $text->save();

        return response()->json(['message' => 'Text updated successfully', 'data' => $text], 200);
    }
}
