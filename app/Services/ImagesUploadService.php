<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImagesUploadService
{
    public function uploadImages(Request $request, $user, $folder)
    {
        if ($request->hasFile('images')) {
            // حذف الصور القديمة إذا كانت موجودة
            if ($user->images) {
                $oldImages = json_decode($user->images, true);
                foreach ($oldImages as $oldImage) {
                    if (File::exists(public_path($oldImage))) {
                        File::delete(public_path($oldImage));
                    }
                }
            }

            // مصفوفة لتخزين مسارات الصور
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                // الحصول على الامتداد الأصلي للصورة
                $filename = date('Ymd-His') . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path($folder);

                // إنشاء المجلد إذا لم يكن موجودًا
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true);
                }

                // نقل الصورة إلى المسار المحدد
                $image->move($destinationPath, $filename);

                // إضافة المسار إلى المصفوفة
                $imagePaths[] = url('/') . '/' . $folder . '/' . $filename;
            }

            // حفظ مسارات الصور في قاعدة البيانات
            $user->images = $imagePaths; // افترض أن لديك حقل images في جدول المستخدم
            $user->save();
        }
    }
}
