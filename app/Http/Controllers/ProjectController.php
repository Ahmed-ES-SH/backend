<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
{

    protected $ImageUploadService;

    public function __construct(ImageUploadService $imagesUploadService)
    {
        $this->ImageUploadService = $imagesUploadService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projects = Project::orderBy('created_at', 'desc')->paginate(6);
            return response()->json([
                'data' => $projects->items(),  // العناصر الحالية فقط
                'total' => $projects->total(), // إجمالي العناصر
                'per_page' => $projects->perPage(), // عدد العناصر في كل صفحة
                'current_page' => $projects->currentPage(), // الصفحة الحالية
                'last_page' => $projects->lastPage(), // آخر صفحة
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'Message' => $e->getMessage()
            ]);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validation = Validator::make($request->all(), [
                "title_ar"  => "required|string",
                "title_en"  => "required|string",
                "description_ar" => "required|string",
                "description_en" => "required|string",
                "image" => "required|image|file",
                "completion_date" => "nullable|date",
                "project_link" => "nullable|url",
                "client_name" => "nullable|string",
                "category" => "required|string",
                "video_link" => "nullable|url",
                "awards" => "nullable|string",
                "technologies_used"   => "required|string",
            ]);


            if ($validation->fails()) {
                return response()->json([
                    'errors' => $validation->errors()
                ], 422);
            }

            $technologies_used = json_decode($request->technologies_used, true);

            $project = new Project();

            $project->fill($request->only([
                'title_ar',
                'title_en',
                'description_ar',
                'description_en',
                'completion_date',
                'project_link',
                'client_name',
                'category',
                'video_link',
                'awards',
            ]));

            $project->technologies_used  = $technologies_used;

            $this->ImageUploadService->uploadImage($request, $project, 'projects/');
            $project->save();
            return response()->json([
                'Message' => 'Project Add Successfully',
                'data' => $project
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'Message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // العثور على المشروع
            $project = Project::findOrFail($id);

            return response()->json([
                'Message' => 'Project details retrieved successfully',
                'data' => $project
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'Message' => 'Project not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'Message' => $e->getMessage()
            ], 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // التحقق من صحة البيانات
            $validation = Validator::make($request->all(), [
                "name"  => "sometimes|string",
                "description" => "sometimes|string",
                "image" => "sometimes|image",
                "completion_date" => "sometimes|date",
                "project_link" => "sometimes|url",
                "client_name" => "sometimes|string",
                "category" => "sometimes|string",
                "video_link" => "nullable|url",
                "awards" => "nullable|string",
                "technologies_used"   => "nullable|string",
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'errors' => $validation->errors()
                ], 422);
            }

            $technologies_used = json_decode($request->technologies_used, true);

            // العثور على المشروع
            $project = Project::findOrFail($id);

            // حذف الصور القديمة إذا تم رفع صور جديدة
            $this->ImageUploadService->uploadImage($request, $project, 'projects/');


            // تحديث باقي الحقول
            $project->fill($request->only([
                'title_ar',
                'title_en',
                'description_ar',
                'description_en',
                'completion_date',
                'project_link',
                'client_name',
                'category',
                'video_link',
                'awards',

            ]));

            $project->technologies_used = $technologies_used;

            $project->save();

            return response()->json([
                'Message' => 'Project updated successfully',
                'data' => $project
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // العثور على المشروع
            $project = Project::findOrFail($id);

            // حذف الصور من التخزين
            $images = json_decode($project->images, true);
            if ($images) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            // حذف المشروع
            $project->delete();

            return response()->json([
                'Message' => 'Project deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Message' => $e->getMessage()
            ], 500);
        }
    }
}
