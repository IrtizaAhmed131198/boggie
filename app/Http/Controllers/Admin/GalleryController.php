<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Image;
use File;

class GalleryController extends Controller
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
        $model = str_slug('gallery', '-');
        if (auth()->user()->permissions()->where('name', '=', 'view-' . $model)->first() != null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $gallery = gallery::where('Image', 'LIKE', "%$keyword%")
                    ->paginate($perPage);
            } else {
                $gallery = gallery::paginate($perPage);
            }

            return view('gallery.gallery.index', compact('gallery'));
        }
        return response(view('403'), 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = str_slug('gallery', '-');
        if (auth()->user()->permissions()->where('name', '=', 'add-' . $model)->first() != null) {
            return view('gallery.gallery.create');
        }
        return response(view('403'), 403);
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
        $model = str_slug('gallery', '-');
        if (auth()->user()->permissions()->where('name', '=', 'add-' . $model)->first() != null) {


            $gallery = new gallery($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                //make sure yo have image folder inside your public
                $gallery_path = 'uploads/gallerys/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd") . $fileName . "." . $file->getClientOriginalExtension();

                Image::make($file)->save(public_path($gallery_path) . DIRECTORY_SEPARATOR . $profileImage);

                $gallery->image = $gallery_path . $profileImage;
            }

            $gallery->save();
            return redirect()->back()->with('message', 'gallery added!');
        }
        return response(view('403'), 403);
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
        $model = str_slug('gallery', '-');
        if (auth()->user()->permissions()->where('name', '=', 'view-' . $model)->first() != null) {
            $gallery = gallery::findOrFail($id);
            return view('gallery.gallery.show', compact('gallery'));
        }
        return response(view('403'), 403);
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

        $image = Gallery::findOrFail($id);
        if($image->status === 'approved'){
        $image->status = 'pending';
        $image->save();
        }else{
            $image->status = 'approved';
            $image->save();
        }

        return redirect()->back()->with('message', 'Image approved successfully.');
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
        $model = str_slug('gallery', '-');
        if (auth()->user()->permissions()->where('name', '=', 'edit-' . $model)->first() != null) {

            $requestData = $request->all();


            if ($request->hasFile('image')) {

                $gallery = gallery::where('id', $id)->first();
                $image_path = public_path($gallery->image);

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                $file = $request->file('image');
                $fileNameExt = $request->file('image')->getClientOriginalName();
                $fileNameForm = str_replace(' ', '_', $fileNameExt);
                $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
                $fileExt = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
                $pathToStore = public_path('uploads/gallerys/');
                Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR . $fileNameToStore);

                $requestData['image'] = 'uploads/gallerys/' . $fileNameToStore;
            }


            $gallery = gallery::findOrFail($id);
            $gallery->update($requestData);
            return redirect()->back()->with('message', 'gallery updated!');
        }
        return response(view('403'), 403);
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
        $model = str_slug('gallery', '-');
        if (auth()->user()->permissions()->where('name', '=', 'delete-' . $model)->first() != null) {
            gallery::destroy($id);
            return redirect()->back()->with('message', 'gallery deleted!');
        }
        return response(view('403'), 403);
    }
}
