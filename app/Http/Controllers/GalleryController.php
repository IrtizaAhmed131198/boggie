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
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = 'uploads/gallery/' . $filename;
    
                // Ensure directory exists
                if (!file_exists(public_path('uploads/gallery'))) {
                    mkdir(public_path('uploads/gallery'), 0777, true);
                }
    
                // Save Image
                Image::make($file)->save(public_path($path));
    
                // Save to Database as "Pending"
                Gallery::create([
                    'path' => $path,
                    'status' => 'pending'
                ]);
            }
        }

        return redirect()->back()->with('message', 'Images uploaded successfully!');
    }
}
