<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogPostController extends Controller
{


    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService; // حقن الـ Service
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $Posts = BlogPost::orderBy('created_at', 'desc')->paginate(6);
            return response()->json([
                'data' => $Posts->items(),  // العناصر الحالية فقط
                'total' => $Posts->total(), // إجمالي العناصر
                'per_page' => $Posts->perPage(), // عدد العناصر في كل صفحة
                'current_page' => $Posts->currentPage(), // الصفحة الحالية
                'last_page' => $Posts->lastPage(), // آخر صفحة
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
                'title_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'content_ar' => 'required|string',
                'content_en' => 'required|string',
                'author' => 'required|string|max:100',
                'published_date' => 'nullable|date',
                'category' => 'nullable',
                'tags' => 'nullable|string',
                'status' => 'in:draft,published,archived',
                'views' => 'nullable|integer',
                'comments_count' => 'nullable|integer',
                'excerpt' => 'nullable|string',
                'interactions' => 'nullable|json', // تأكد من أن التفاعلات في صيغة JSON
            ]);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()]);
            }

            $post = new BlogPost();

            $post->fill($request->only([
                'title_ar',
                'title_en',
                'content_ar',
                'content_en',
                'author',
                'published_date',
                'category',
                'tags',
                'status',
                'views',
                'comments_count',
                'excerpt',
                'interactions',
            ]));

            $this->imageUploadService->uploadImage($request, $post, 'blogs/');
            $post->save();

            return response()->json([
                'data' => $post,
                'Message' => 'Post Added Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'Message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // البحث عن المقالة أو إرجاع 404 إذا لم توجد
            $post = BlogPost::findOrFail($id);

            return response()->json(['data' => $post], 200); // إرجاع المقالة مع كود الحالة 200
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the post.',
                'error' => $e->getMessage()
            ], 500); // إرجاع كود الحالة 500 لأي أخطاء
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // البحث عن المقالة أو إرجاع 404 إذا لم توجد
            $post = BlogPost::findOrFail($id);

            // التحقق من صحة البيانات المدخلة
            $validation = Validator::make($request->all(), [
                'title_ar' => 'sometimes|string|max:255',
                'title_end' => 'sometimes|string|max:255',
                'content_ar' => 'sometimes|string',
                'content_en' => 'sometimes|string',
                'author' => 'nullable|string|max:100',
                'published_date' => 'nullable|date',
                'category' => 'nullable',
                'tags' => 'nullable|string',
                'status' => 'in:draft,published,archived',
                'views' => 'nullable|integer',
                'comments_count' => 'nullable|integer',
                'excerpt' => 'nullable|string',
                'interactions' => 'nullable|json', // تأكد من أن التفاعلات في صيغة JSON
            ]);

            // إذا كانت هناك أخطاء في التحقق
            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 422);
            }

            // تعبئة البيانات الجديدة
            $post->fill($request->only([
                'title_ar',
                'title_en',
                'content_en',
                'content_ar',
                'author',
                'published_date',
                'category',
                'tags',
                'status',
                'views',
                'comments_count',
                'excerpt',
                'interactions',
            ]));

            if ($request->has('image')) {
                if ($post->image) { // تأكد من أن العمود في قاعدة البيانات هو 'image' وليس 'images'
                    // مسار الصورة القديمة
                    $oldImagePath = public_path('blogs/' . $post->image);

                    // حذف الصورة القديمة من التخزين
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
                $this->imageUploadService->uploadImage($request, $post, 'blogs/');
            }

            // رفع الصور الجديدة إذا كانت موجودة


            $post->save(); // حفظ التغييرات

            return response()->json([
                'data' => $post,
                'message' => 'Post Updated Successfully'
            ], 200); // إرجاع كود الحالة 200 عند النجاح
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the post.',
                'error' => $e->getMessage()
            ], 500); // إرجاع كود الحالة 500 لأي أخطاء
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // البحث عن المقالة أو إرجاع 404 إذا لم توجد
            $post = BlogPost::findOrFail($id);

            // مسح الصور القديمة إذا كانت موجودة
            if ($post->images) {
                $oldImages = json_decode($post->images, true);
                foreach ($oldImages as $image) {
                    // حذف الصورة القديمة من التخزين
                    if (Storage::exists('posts/' . $image)) {
                        Storage::delete('posts/' . $image);
                    }
                }
            }

            // حذف المقالة
            $post->delete();

            return response()->json([
                'message' => 'Post Deleted Successfully'
            ], 200); // إرجاع كود الحالة 200 عند النجاح
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the post.',
                'error' => $e->getMessage()
            ], 500); // إرجاع كود الحالة 500 لأي أخطاء
        }
    }
}
