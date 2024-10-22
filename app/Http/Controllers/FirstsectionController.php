<?php

namespace App\Http\Controllers;

use App\Models\firstsection;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\File;

class FirstsectionController extends Controller
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
            $texts = firstsection::all();

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
            'text1_ar' => 'sometimes|string|max:255',
            'text1_en' => 'sometimes|string|max:255',
            'text2_ar' => 'sometimes|string|max:255',
            'text2_en' => 'sometimes|string|max:255',
            'text3_ar' => 'sometimes|string|max:255',
            'text3_en' => 'sometimes|string|max:255',
            'text4_ar' => 'sometimes|string|max:255',
            'text4_en' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // البحث عن النصوص حسب المعرف
        $text = firstsection::findOrFail(1);
        // return $request->text1_ar ;

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
        if ($request->has('text4_ar')) {
            $text->text4_ar = $request->text4_ar;
        }
        if ($request->has('text4_en')) {
            $text->text4_en = $request->text4_en;
        }

        // تحديث الصورة إذا تم إرسالها
        $this->imageUploadService->uploadImage($request, $text, 'images');

        // حفظ التغييرات
        $text->save();

        return response()->json(['message' => 'Text updated successfully', 'data' => $text], 200);
    }
}
