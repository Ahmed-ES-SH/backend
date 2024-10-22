<?php

namespace App\Services;

use Illuminate\Http\Request;

class ImageUploadService
{
    public function uploadImage(Request $request, $user, $folder)
    {
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
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
            $user->image = $folder . '/' . $filename;
            $user->image = url('/') . '/' . $folder . '/' . $filename;
            $user->save();
        }
    }
}
