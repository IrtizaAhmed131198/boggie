<?php

namespace App\Http\Controllers\Logo;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $logo = Logo::where('image', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $logo = Logo::paginate($perPage);
            }

            return view('logo.logo.index', compact('logo'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('logo.logo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
            $logo = new Logo($request->all());

            if ($request->hasFile('image')) {
                $file = $request->file('image');
            
                // Ensure the directory exists
                $logo_path = public_path('uploads/logo/');
                if (!file_exists($logo_path)) {
                    mkdir($logo_path, 0777, true);
                }
            
                // Generate a unique file name
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $profileImage = date("Ymd") . "_" . $fileName . "." . $file->getClientOriginalExtension();
            
                // Save the image
                Image::make($file)->save($logo_path . $profileImage);
            
                // Store path in database
                $logo->image = 'uploads/logo/' . $profileImage;
            }
            
            
            $logo->save();
            return redirect()->back()->with('message', 'Logo added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
            $logo = Logo::findOrFail($id);
            return view('logo.logo.show', compact('logo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
            $logo = Logo::findOrFail($id);
            return view('logo.logo.edit', compact('logo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {    
        $logo = Logo::findOrFail($id);
        $requestData = $request->all();
    
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($logo->image && File::exists(public_path($logo->image))) {
                File::delete(public_path($logo->image));
            }
    
            // Process new image
            $file = $request->file('image');
            $fileName = str_replace(' ', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $fileNameToStore = $fileName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $pathToStore = public_path('uploads/logos/');
    
            // Ensure directory exists
            File::ensureDirectoryExists($pathToStore, 0755, true);
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR . $fileNameToStore);
    
            $requestData['image'] = 'uploads/logos/' . $fileNameToStore;
        }
    
        $logo->update($requestData);
        return back()->with('message', 'Logo updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
            Logo::destroy($id);
            return redirect()->back()->with('message', 'Logo deleted!');
        }
}
