<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;

class TestimonialController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService; // حقن الـ Service
    }

    // Get all customer feedback
    public function index()
    {
        $feedbacks = Testimonial::all();
        return response()->json($feedbacks);
    }

    // Store new feedback
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:20000',
            'content' => 'required|string',
        ]);

        // Handle file upload using the ImageUploadService
        $feedback = new Testimonial();
        $feedback->client_name = $request->client_name;
        $feedback->content = $request->content;
        $this->imageUploadService->uploadImage($request, $feedback, 'testimonial/');
        $feedback->save();

        return response()->json($feedback, 201);
    }

    // Show specific feedback
    public function show($id)
    {
        $feedback = Testimonial::findOrFail($id);
        return response()->json($feedback);
    }

    // Update feedback
    public function update(Request $request, $id)
    {
        $feedback = Testimonial::findOrFail($id);

        $request->validate([
            'client_name' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:20000',
            'content' => 'sometimes|required|string',
        ]);

        // Handle file upload if new image is provided using the ImageUploadService

        $this->imageUploadService->uploadImage($request, $feedback, 'testimonial/');



        $feedback->client_name = $request->input('client_name', $feedback->client_name);
        $feedback->content = $request->input('content', $feedback->content);
        $feedback->save();

        return response()->json($feedback);
    }

    // Delete feedback
    public function destroy($id)
    {
        $feedback = Testimonial::findOrFail($id);
        $feedback->delete();
        return response()->json(null, 204);
    }
}
