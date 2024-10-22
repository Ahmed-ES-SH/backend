<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    // عرض جميع القوائم
    public function index()
    {
        try {
            // العثور على السجل باستخدام FindOrFail
            $footer = Footer::findOrFail(1);

            // تحويل القوائم إلى مصفوفات إذا لم تكن مصفوفة
            foreach (['list1', 'list2', 'list3', 'list4', 'list5'] as $list) {
                // استخدام json_decode لتحويل السلاسل النصية إلى مصفوفات
                $decodedList = is_string($footer->$list) ? json_decode($footer->$list, true) : $footer->$list;

                // التأكد من أن البيانات المحولة عبارة عن مصفوفة، إذا لم تكن، اجعلها مصفوفة فارغة
                $footer->$list = is_array($decodedList) ? $decodedList : [];
            }

            return response()->json($footer);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    // إضافة أو تعديل قائمة معينة
    public function updateList(Request $request)
    {


        $footerList = Footer::findOrFail(1); // في حال كانت البيانات كلها في صف واحد

        if ($request->list1) {
            $footerList->list1 = $request->list1;
        }
        if ($request->list2) {
            $footerList->list2 = $request->list2;
        }
        if ($request->list3) {
            $footerList->list3 = $request->list3;
        }
        if ($request->list4) {
            $footerList->list4 = $request->list4;
        }
        if ($request->list5) {
            $footerList->list5 = $request->list5;
        }


        $footerList->save(); // حفظ التغييرات

        return response()->json($footerList);
    }

    // جلب قائمة معينة بناءً على رقم القائمة
    public function getList($listNumber)
    {
        $footerList = Footer::first(); // في حال كانت البيانات كلها في صف واحد

        if (!$footerList) {
            return response()->json(['message' => 'No footer lists found'], 404);
        }

        // تحديد القائمة المراد جلبها بناءً على الرقم
        $listField = 'list' . $listNumber;

        if (in_array($listField, ['list1', 'list2', 'list3', 'list4', 'list5'])) {
            return response()->json([$listField => $footerList->$listField]);
        } else {
            return response()->json(['message' => 'Invalid list number'], 400);
        }
    }

    // حذف قائمة معينة بناءً على رقم القائمة
    public function deleteList($listNumber)
    {
        $footerList = Footer::first(); // في حال كانت البيانات كلها في صف واحد

        if (!$footerList) {
            return response()->json(['message' => 'No footer lists found'], 404);
        }

        // تحديد القائمة المراد حذفها بناءً على الرقم
        $listField = 'list' . $listNumber;

        if (in_array($listField, ['list1', 'list2', 'list3', 'list4', 'list5'])) {
            $footerList->update([
                $listField => [],
            ]);
            return response()->json(['message' => "List $listNumber deleted successfully", 'footerList' => $footerList]);
        } else {
            return response()->json(['message' => 'Invalid list number'], 400);
        }
    }
}
