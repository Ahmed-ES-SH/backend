<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{

    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService; // حقن الـ Service
    }
    // دالة تسجيل مستخدم جديد
    public function register(Request $request)
{
    try {
        // التحقق من صحة البيانات
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:users,name',
            'last_name' => 'required|unique:users,last_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:52',
            'password_confirm' => 'required|same:password|min:6|max:52', // تحقق من مطابقة كلمة المرور
            'phone_number' => 'nullable',
            'image' => 'nullable|file|image|max:20000', // تحديد الحد الأقصى لحجم الصورة
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        // إنشاء مستخدم جديد
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        // تشفير كلمة المرور باستخدام Hash::make
        $user->password = Hash::make($request->password);

        // حفظ المستخدم في قاعدة البيانات
        $user->save();

        // رفع الصورة إذا تم إرسالها
        $this->imageUploadService->uploadImage($request, $user, 'users/' . $user->id);
        $token = $user->createToken('auth_token')->plainTextToken;
        // استجابة النجاح
        return response()->json([
            'message' => 'User created successfully',
            'token' => $token,
            'user' => $user
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 500);
    }
}

 
    
    public function login(Request $request)
    {
        // التحقق من صحة البيانات
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
    
        // البحث عن المستخدم باستخدام نموذج Eloquent
        $user = User::where('email', $request->email)->first();
    
        // التحقق من وجود المستخدم وكلمة المرور
        if ($user && Hash::check($request->password, $user->password)) {
            // إنشاء توكن جديد للمستخدم
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ], 200);
        }
    
        // في حالة الفشل
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    

    // دالة تسجيل الخروج
    public function logout(Request $request)
    {
        try {
            // تحقق مما إذا كان المستخدم قد سجل الدخول بالفعل
            if (!$request->user()) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            // إبطال التوكن الحالي
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (\Exception $e) {
            // إذا حدث خطأ ما، ارجع رسالة الخطأ مع كود الحالة 500
            return response()->json(['message' => 'Logout failed: ' . $e->getMessage()], 500);
        }
    }

    // دالة المستخدم الحالى 
    public function currentUser(Request $request)
    {
        try {
            // استرجاع المستخدم الحالي
            $user = $request->user();

            // تحقق مما إذا كان هناك مستخدم مسجل
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            // إذا حدث خطأ ما، ارجع رسالة الخطأ مع كود الحالة 500
            return response()->json(['message' => 'Failed to retrieve user: ' . $e->getMessage()], 500);
        }
    }
}
