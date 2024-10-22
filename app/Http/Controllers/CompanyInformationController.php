<?php

namespace App\Http\Controllers;

use App\Models\CompanyInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyInformationController extends Controller
{




    public function index()
    {
        try {

            $all_details = CompanyInformation::all();

            return response()->json([
                "data" => $all_details
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function store(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validation = Validator::make($request->all(), [
                'aboutcontent_ar' => 'nullable|string',
                'aboutcontent_en' => 'nullable|string',
                'vision_ar' => 'nullable|string',
                'vision_en' => 'nullable|string',
                'goals_ar' => 'nullable|string',
                'goals_en' => 'nullable|string',
                'values_en' => 'nullable|string',
                'values_ar' => 'nullable|string',
                'address' => 'nullable|string',
                'vision_image' => 'nullable|image',
                'about_image' => 'nullable|image',
                'goals_image' => 'nullable|image',
                'values_image' => 'nullable|image',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'errors' => $validation->errors()
                ], 422);
            }

            $CompanyInformation = new CompanyInformation();

            $CompanyInformation->fill($request->only([
                'aboutcontent_ar',
                'aboutcontent_en',
                'vision_ar',
                'vision_en',
                'goals_ar',
                'goals_en',
                'values_en',
                'values_ar',
                'address',
            ]));

            // استخدام الدالة الخاصة لرفع الصور
            $this->handleImageUpload($request, $CompanyInformation, 'company/vision', 'vision_image');
            $this->handleImageUpload($request, $CompanyInformation, 'company/goals', 'goals_image');
            $this->handleImageUpload($request, $CompanyInformation, 'company/values', 'values_image');
            $this->handleImageUpload($request, $CompanyInformation, 'company/about', 'about_image');

            $CompanyInformation->save();

            return response()->json(['message' => 'Company info saved successfully', 'data' => $CompanyInformation], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }



    public function show($id)
    {
        try {
            $details = CompanyInformation::findOrFail($id);

            return response()->json([
                'data' => $details
            ], 200); // كود الحالة 200 (نجاح)
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Company information not found'
            ], 404); // كود الحالة 404 (غير موجود)
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500); // كود الحالة 500 (خطأ داخلي)
        }
    }


    public function update(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validation = Validator::make($request->all(), [
                'aboutcontent_en' => 'sometimes|string',
                'aboutcontent_ar' => 'sometimes|string',
                'goals_en' => 'sometimes|string',
                'goals_ar' => 'sometimes|string',
                'value_en' => 'sometimes|string',
                'value_ar' => 'sometimes|string',
                'vision_en' => 'sometimes|string',
                'vision_ar' => 'sometimes|string',
                'about_image' => 'sometimes|image',
                'values_image' => 'sometimes|image',
                'goals_image' => 'sometimes|image',
                'vision_image' => 'sometimes|image',
                'show_map' => 'sometimes', // إضافة حقل show_map
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'errors' => $validation->errors()
                ], 422);
            }

            // البحث عن معلومات الشركة
            $companyInformation = CompanyInformation::findOrFail(1);

            // ملء الحقول النصية
            $companyInformation->fill($request->only([
                'aboutcontent_en',
                'aboutcontent_ar',
                'goals_en',
                'goals_ar',
                'value_en',
                'value_ar',
                'vision_en',
                'vision_ar',
                'show_map' // إضافة show_map
            ]));

            // مسح الصور القديمة إذا كانت موجودة
            $imageFields = [
                'about_image',
                'values_image',
                'goals_image',
                'vision_image'
            ];

            foreach ($imageFields as $field) {
                if ($request->hasFile($field) && $companyInformation->{$field}) {
                    // حذف الصورة القديمة
                    if (file_exists(public_path($companyInformation->{$field}))) {
                        unlink(public_path($companyInformation->{$field}));
                    }
                }
            }

            // استخدام الدالة الخاصة لرفع الصور
            $this->handleImageUpload($request, $companyInformation, 'company/about', 'about_image');
            $this->handleImageUpload($request, $companyInformation, 'company/value', 'values_image');
            $this->handleImageUpload($request, $companyInformation, 'company/goals', 'goals_image');
            $this->handleImageUpload($request, $companyInformation, 'company/vision', 'vision_image');

            // حفظ التحديثات
            $companyInformation->save();

            return response()->json(['message' => 'Company info updated successfully', 'data' => $companyInformation], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }




    public function updateContactInfo(Request $request)
    {
        try {
            // التحقق من صحة البيانات الواردة
            $validation = Validator::make($request->all(), [
                'whatsapp_number' => 'nullable|string|max:20',
                'gmail_account' => 'nullable|email|max:255',
                'address' => 'nullable|string|max:255',
                'show_map' => 'nullable',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'errors' => $validation->errors()
                ], 422);
            }

            // البحث عن العنصر ذو المعرف رقم 1
            $companyInformation = CompanyInformation::findOrFail(1);

            // تحديث الأعمدة المطلوبة فقط
            $companyInformation->update([
                'whatsapp_number' => $request->whatsapp_number,
                'gmail_account' => $request->gmail_account,
                'address' => $request->address,
                'show_map' => $request->show_map,
            ]);

            return response()->json(['message' => 'Contact info updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating contact info: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getContactInfo()
    {
        try {
            // البحث عن العنصر ذو المعرف رقم 1
            $companyInformation = CompanyInformation::findOrFail(1, ['whatsapp_number', 'gmail_account', 'address', 'show_map']);

            // إرجاع البيانات المطلوبة
            return response()->json([
                'whatsapp_number' => $companyInformation->whatsapp_number,
                'gmail_account' => $companyInformation->gmail_account,
                'address' => $companyInformation->address,
                'show_map' => $companyInformation->show_map,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving contact info: ' . $e->getMessage()
            ], 500);
        }
    }






    public function destroy($id)
    {
        try {
            // البحث عن معلومات الشركة بناءً على المعرف
            $companyInformation = CompanyInformation::findOrFail($id);

            // قائمة الحقول التي تحتوي على الصور
            $imageFields = ['vision_image', 'goals_image', 'values_image'];

            // حذف الصور القديمة إذا كانت موجودة
            foreach ($imageFields as $field) {
                if ($companyInformation->$field) {
                    Storage::disk('public')->delete($companyInformation->$field);
                }
            }

            // حذف معلومات الشركة
            $companyInformation->delete();

            return response()->json([
                'message' => 'Company information deleted successfully'
            ], 200); // كود الحالة 200 للإشارة إلى النجاح
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500); // كود الحالة 500 للأخطاء العامة
        }
    }



    private function handleImageUpload($request, $user, $folder, $imageField)
    {
        if ($request->hasFile($imageField)) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            // رفع الصورة الجديدة
            $image = $request->file($imageField);
            $filename = date('Ymd-His') . '.' . $image->getClientOriginalExtension(); // الحصول على الامتداد الأصلي للصورة
            $destinationPath = public_path($folder); // المسار الذي سيتم تخزين الصورة فيه

            // إنشاء المجلد إذا لم يكن موجودًا
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // نقل الصورة إلى المسار المحدد
            $image->move($destinationPath, $filename);

            // حفظ مسار الصورة في قاعدة البيانات
            $user->$imageField = $folder . '/' . $filename; // حفظ المسار النسبي
            $user->$imageField = url('/') . '/' . $folder . '/' . $filename; // حفظ المسار الكامل
            $user->save();
        }
    }
}
