<?php

namespace App\Http\Controllers;

use App\Models\forth_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Services\ImageUploadService;

class ForthSectionController extends Controller
{

    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService; // حقن الـ Service
    }


    public function getForthSection()
    {
        $section = forth_section::findOrFail(1);
        return response()->json(['data' => $section], 200);
    }

    public function getFAQImage()
    {
        $section = forth_section::findOrFail(1);

        if ($section->FAQ_image) {
            $imageURL = url($section->FAQ_image); // Generate full URL for the FAQ image
            return response()->json(['FAQ_image' => $imageURL], 200);
        }

        return response()->json(['message' => 'FAQ image not found'], 404);
    }


    public function getContactImage()
    {
        $section = forth_section::findOrFail(1);

        if ($section->contact_img) {
            $imageURL = url($section->contact_img); // Generate full URL for the contact image
            return response()->json(['contact_img' => $imageURL], 200);
        }

        return response()->json(['message' => 'Contact image not found'], 404);
    }

    // Function to update text and main image
    public function updateTextAndImage(Request $request)
    {
        $request->validate([
            'text1_en' => 'sometimes|string',
            'text1_ar' => 'sometimes|string',
            'text2_en' => 'sometimes|string',
            'text2_ar' => 'sometimes|string',
            'text3_en' => 'sometimes|string',
            'text3_ar' => 'sometimes|string',
            'image'    => 'sometimes|image',
        ]);

        $section = forth_section::findOrFail(1);

        // Update text fields
        $section->update($request->only(['text1_en', 'text1_ar', 'text2_en', 'text2_ar', 'text3_en', 'text3_ar']));

        // Update main image
        if ($request->hasFile('image')) {

            $section->image = $this->imageUploadService->uploadImage($request, $section,   'images');
        }

        $section->save();

        return response()->json(['message' => 'Text and main image updated successfully', 'data' => $section]);
    }

    // Function to update FAQ image
    public function updateFAQImage(Request $request)
    {
        $request->validate([
            'FAQ_image' => 'sometimes|image',
        ]);

        $folder = 'images';
        $section = forth_section::findOrFail(1);

        // Update FAQ image
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($section->image && file_exists(public_path($section->image))) {
                unlink(public_path($section->image));
            }

            // رفع الصورة الجديدة
            $image = $request->file('image');
            $filename = date('Ymd-His') . '.' . $image->getClientOriginalExtension(); // الحصول على الامتداد الأصلي للصورة
            $destinationPath = public_path($folder); // المسار الذي سيتم تخزين الصورة فيه

            // إنشاء المجلد إذا لم يكن موجودًا
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // نقل الصورة إلى المسار المحدد
            $image->move($destinationPath, $filename);

            // حفظ مسار الصورة في قاعدة البيانات
            $section->FAQ_image = $folder . '/' . $filename;
            $section->FAQ_image = url('/') . '/' . $folder . '/' . $filename;
        }
        $section->save();

        return response()->json(['message' => 'FAQ image updated successfully', 'data' => $section]);
    }

    // Function to update contact image
    public function updateContactImage(Request $request)
    {
        $request->validate([
            'contact_img' => 'required|image',
        ]);
        $folder = 'images';
        $section = forth_section::findOrFail(1);

        // Update contact image
        if ($request->hasFile('contact_img')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($section->image && file_exists(public_path($section->image))) {
                unlink(public_path($section->image));
            }

            // رفع الصورة الجديدة
            $image = $request->file('contact_img');
            $filename = date('Ymd-His') . '.' . $image->getClientOriginalExtension(); // الحصول على الامتداد الأصلي للصورة
            $destinationPath = public_path($folder); // المسار الذي سيتم تخزين الصورة فيه

            // إنشاء المجلد إذا لم يكن موجودًا
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // نقل الصورة إلى المسار المحدد
            $image->move($destinationPath, $filename);

            // حفظ مسار الصورة في قاعدة البيانات
            $section->contact_img = $folder . '/' . $filename;
            $section->contact_img = url('/') . '/' . $folder . '/' . $filename;
        }

        $section->save();

        return response()->json(['message' => 'Contact image updated successfully', 'data' => $section]);
    }
}
