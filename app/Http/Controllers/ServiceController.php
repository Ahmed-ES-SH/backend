<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Services\ImagesUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    protected $ImagesUploadService;

    public function __construct(ImagesUploadService $imagesUploadService)
    {
        $this->ImagesUploadService = $imagesUploadService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $services = Service::orderBy('created_at', 'desc')->paginate(6);
            return response()->json([
                'data' => $services->items(),
                'total' => $services->total(),
                'per_page' => $services->perPage(),
                'current_page' => $services->currentPage(),
                'last_page' => $services->lastPage(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'features' => 'nullable',
                'expected_benefit_percentage' => 'nullable|numeric',
                'starting_price' => 'nullable|numeric',
                'images' => 'nullable|array',
                'icon' => 'required|image|file',
                'sub_category_id' => 'nullable|exists:sub_categories,id',
            ]);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 422);
            }

            $features = json_decode($request->features, true);

            $service = new Service();
            $service->fill($request->only(['title_en', 'title_ar', 'description_en', 'description_ar',  'expected_benefit_percentage', 'starting_price', 'sub_category_id']));
            $service->features = $features;
            $this->ImagesUploadService->uploadImages($request, $service, 'services/'); // رفع الصور

            if ($request->hasFile('icon')) {
                $folder = 'images';
                // حذف الصورة القديمة إذا كانت موجودة
                if ($service->image && file_exists(public_path($service->image))) {
                    unlink(public_path($service->image));
                }

                // رفع الصورة الجديدة
                $image = $request->file('icon');
                $filename = date('Ymd-His') . '.' . $image->getClientOriginalExtension(); // الحصول على الامتداد الأصلي للصورة
                $destinationPath = public_path($folder); // المسار الذي سيتم تخزين الصورة فيه

                // إنشاء المجلد إذا لم يكن موجودًا
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // نقل الصورة إلى المسار المحدد
                $image->move($destinationPath, $filename);

                // حفظ مسار الصورة في قاعدة البيانات
                $service->icon = $folder . '/' . $filename;
                $service->icon = url('/') . '/' . $folder . '/' . $filename;
                $service->save();
            }

            $service->save();

            return response()->json(['message' => 'Service created successfully', 'data' => $service], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json(['data' => $service], 200);
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'features' => 'nullable',
                'expected_benefit_percentage' => 'nullable|numeric',
                'starting_price' => 'nullable|numeric',
                'images' => 'nullable|array',
                'icon' => 'nullable|image',
            ]);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 422);
            }

            $features = json_decode($request->features, true);

            $service = Service::findOrFail($id);

            $service->fill($request->only(['title', 'description', 'expected_benefit_percentage', 'starting_price']));
            $service->features = $features;

            if ($request->hasFile('images')) {
                // يمكنك إضافة كود لحذف الصور القديمة هنا إذا لزم الأمر
                $this->ImagesUploadService->uploadImages($request, $service, 'services/'); // رفع الصور
            }

            if ($request->hasFile('icon')) {
                $folder = 'images';
                // حذف الصورة القديمة إذا كانت موجودة
                if ($service->icon && file_exists(public_path($service->icon))) {
                    unlink(public_path($service->icon));
                }

                // رفع الصورة الجديدة
                $image = $request->file('icon');
                $filename = date('Ymd-His') . '.' . $image->getClientOriginalExtension(); // الحصول على الامتداد الأصلي للصورة
                $destinationPath = public_path($folder); // المسار الذي سيتم تخزين الصورة فيه

                // إنشاء المجلد إذا لم يكن موجودًا
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // نقل الصورة إلى المسار المحدد
                $image->move($destinationPath, $filename);

                // حفظ مسار الصورة في قاعدة البيانات
                $service->icon = $folder . '/' . $filename;
                $service->icon = url('/') . '/' . $folder . '/' . $filename;
                $service->save();
            }

            $service->save();

            return response()->json(['message' => 'Service updated successfully', 'data' => $service], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            // حذف الصور القديمة إذا كانت موجودة
            if ($service->images) {
                foreach (json_decode($service->images) as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            if ($service->icon && file_exists(public_path($service->icon))) {
                unlink(public_path($service->icon));
            }

            $service->delete();
            return response()->json(['message' => 'Service deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
