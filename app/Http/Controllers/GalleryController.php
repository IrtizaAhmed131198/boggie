<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Gallery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function gallery_images(Request $request)
    {
        // Validate request
    $request->validate([
        'images' => 'required',
        'images.*' => 'image|mimes:jpeg,png,gif|max:5120' // Max 5MB per image
    ]);

    // Check if images exist
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'uploads/gallery/' . $filename;
            
            // Ensure directory exists
            if (!file_exists(public_path('uploads/gallery'))) {
                mkdir(public_path('uploads/gallery'), 0777, true);
            }
    
            // Save Image
            \Intervention\Image\Facades\Image::make($file)->save(public_path($path));
    
            // Save to database
            Gallery::create(['path' => $path]);
        }
    }
    


        return redirect()->back()->with('message', 'Images uploaded successfully!');
    }
}
