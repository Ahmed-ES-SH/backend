<?php

// app/Http/Controllers/SubServiceController.php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\sub_service;
use App\Services\ImageUploadService;
use App\Services\ImagesUploadService;
use Illuminate\Http\Request;

class SubServiceController extends Controller
{


    protected $imageUploadService;
    protected $ImagesUploadService;
    public function __construct(ImageUploadService $imageUploadService, ImagesUploadService $imagesUploadService)
    {
        $this->imageUploadService = $imageUploadService; // حقن الـ Service
        $this->ImagesUploadService = $imagesUploadService;
    }






    // عرض جميع الخدمات الفرعية المتعلقة بخدمة أساسية معينة
    public function index($service_id)
    {
        $service = Service::findOrFail($service_id);
        $subServices = $service->subServices;

        return response()->json(['data' => $subServices, 200]);
    }

    // عرض خدمة فرعية واحدة


    // إنشاء خدمة فرعية جديدة
    public function store(Request $request, $service_id)
    {
        try {
            // التحقق من البيانات المدخلة
            $request->validate([
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'image' => 'required|image|file',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // التحقق من الصور المتعددة
            ]);

            // إنشاء خدمة فرعية باستخدام النموذج
            $subService = sub_service::create([
                'service_id' => $service_id, // ربط الخدمة الفرعية بالخدمة الأصلية
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
            ]);

            // رفع صورة الخدمة الفرعية الرئيسية
            $this->imageUploadService->uploadImage($request, $subService, 'subservices/');

            // رفع الصور المتعددة الخاصة بالخدمة الفرعية
            $this->ImagesUploadService->uploadImages($request, $subService, 'subservices/');

            return response()->json(['data' => $subService], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $subservice = sub_service::findorFail($id);
            return response()->json([
                'data' => $subservice
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'messgae' => $e->getMessage()
            ]);
        }
    }

    // تحديث خدمة فرعية
    public function update(Request $request, $sub_service_id)
    {
        try {
            // تحقق من صحة المدخلات
            $request->validate([
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'image' => 'nullable|image|file', // الصورة الأساسية غير مطلوبة
                'images' => "nullable|array" // مصفوفة الصور غير مطلوبة
            ]);

            // العثور على الخدمة الفرعية
            $subService = sub_service::findOrFail($sub_service_id);

            // تحديث الخصائص
            if ($request->has('title_en')) {
                $subService->title_en = $request->title_en;
            }
            if ($request->has('title_ar')) {
                $subService->title_ar = $request->title_ar;
            }
            if ($request->has('description_en')) {
                $subService->description_en = $request->description_en;
            }
            if ($request->has('description_ar')) {
                $subService->description_ar = $request->description_ar;
            }

            // تحديث الصورة إذا تم رفع واحدة
            if ($request->hasFile('image')) {
                // رفع الصورة الأساسية
                $image = $request->file('image');
                $imagePath = 'subservices/' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('subservices'), $imagePath); // استخدام move
                $subService->image = url('/') . '/' . $imagePath; // تحديث مسار الصورة باستخدام url('/')
            }

            // تحديث الصور إذا تم رفعها
            if ($request->has('images')) {
                $newImages = $request->images;

                // تصفية الصور إلى روابط وملفات
                $validUrls = array_filter($newImages, function ($image) {
                    return filter_var($image, FILTER_VALIDATE_URL); // تحقق مما إذا كانت روابط
                });

                $files = array_filter($newImages, function ($image) {
                    return !filter_var($image, FILTER_VALIDATE_URL); // التحقق مما إذا كانت ملفات
                });

                // إذا كانت هناك روابط جديدة، استبدل الصور القديمة
                if (count($validUrls) > 0) {
                    $subService->images = $validUrls; // استبدال الصور القديمة بالصور الجديدة (الروابط)
                }

                // إذا كانت هناك ملفات، قم برفعها وتحويلها إلى روابط
                if (count($files) > 0) {
                    $uploadedImagePaths = [];

                    foreach ($files as $file) {
                        if ($file instanceof \Illuminate\Http\UploadedFile) {
                            $filePath = 'services/' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path('services'), $filePath); // استخدام move
                            $uploadedImagePaths[] = url('/') . '/' . $filePath; // تحديث المسار باستخدام url('/')
                        }
                    }

                    // دمج المسارات المرفوعة مع الصور القديمة
                    $subService->images = array_merge($subService->images, $uploadedImagePaths);
                }
            }

            // حفظ التغييرات
            $subService->save();

            return response()->json(['data' => $subService], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500); // يمكنك تغيير رمز الحالة حسب الحاجة
        }
    }




    // حذف خدمة فرعية
    public function destroy($id)
    {
        try {
            // إيجاد الخدمة الفرعية باستخدام الـ ID
            $subService = sub_service::findOrFail($id);

            // التحقق من وجود الصورة وحذفها من السيرفر
            if ($subService->image) {
                $imagePath = public_path('subservices/' . $subService->image);

                // التأكد من وجود الملف في السيرفر قبل حذفه
                if (file_exists($imagePath)) {
                    unlink($imagePath); // حذف الصورة من السيرفر
                }
            }

            // حذف الخدمة الفرعية من قاعدة البيانات
            $subService->delete();

            // إرجاع استجابة بنجاح العملية
            return response()->json(['message' => 'SubService deleted successfully'], 200);
        } catch (\Exception $e) {
            // إرجاع رسالة خطأ إذا حدثت مشكلة
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
