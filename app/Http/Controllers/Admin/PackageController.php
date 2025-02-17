<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Package;
use App\Product;
use Illuminate\Http\Request;
use Image;
use File;

class PackageController extends Controller
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
        $model = str_slug('package','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $package = Package::with('course')->where('course_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('price', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $package = Package::with('course')->paginate($perPage);
            }

            return view('package.package.index', compact('package'));
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
        $model = str_slug('package','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            $course = Product::whereIn('category', [1,5])->get();
            return view('package.package.create', compact('course'));
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
        $model = str_slug('package','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            $this->validate($request, [
			'course_id' => 'required',
			'name' => 'required',
			'price' => 'required'
		]);

            $package = new Package($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                //make sure yo have image folder inside your public
                $package_path = 'uploads/packages/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

                Image::make($file)->save(public_path($package_path) . DIRECTORY_SEPARATOR. $profileImage);

                $package->image = $package_path.$profileImage;
            }

            $package->save();
            return redirect()->back()->with('message', 'Package added!');
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
        $model = str_slug('package','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $package = Package::findOrFail($id);
            return view('package.package.show', compact('package'));
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
        $model = str_slug('package','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $package = Package::findOrFail($id);
            $course = Product::whereIn('category', [1,5])->get();
            return view('package.package.edit', compact('package', 'course'));
        }
        return response(view('403'), 403);
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
        $model = str_slug('package','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $this->validate($request, [
			'course_id' => 'required',
			'name' => 'required',
			'price' => 'required'
		]);
            $requestData = $request->all();


        if ($request->hasFile('image')) {

            $package = Package::where('id', $id)->first();
            $image_path = public_path($package->image);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/packages/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/packages/'.$fileNameToStore;
        }


            $package = Package::findOrFail($id);
            $package->update($requestData);
            return redirect()->back()->with('message', 'Package updated!');
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
        $model = str_slug('package','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Package::destroy($id);
            return redirect()->back()->with('message', 'Package deleted!');
        }
        return response(view('403'), 403);

    }
}
