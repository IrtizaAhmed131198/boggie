<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Image;
use File;

class VendorsController extends Controller
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
                $vendors = Vendor::where('title', 'LIKE', "%$keyword%")
                ->orWhere('desc', 'LIKE', "%$keyword%")
                ->orWhere('image', 'LIKE', "%$keyword%")
                ->orWhere('link', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $vendors = Vendor::paginate($perPage);
            }

            return view('vendors.vendors.index', compact('vendors'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('vendors.vendors.create');

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
        $vendors = new Vendor($request->all());

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            //make sure yo have image folder inside your public
            $vendors_path = 'uploads/vendorss/';
            $fileName = $file->getClientOriginalName();
            $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

            $file->move(public_path('uploads/vendors/'), $fileNameToStore);

            $vendors->image = $vendors_path.$profileImage;
        }

        $vendors->save();
        return redirect()->back()->with('message', 'Vendor added!');
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
            $vendor = Vendor::findOrFail($id);
            return view('vendors.vendors.show', compact('vendor'));
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
        $vendor = Vendor::findOrFail($id);
        return view('vendors.vendors.edit', compact('vendor'));
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

        $requestData = $request->all();


        if ($request->hasFile('image')) {

            $vendors = Vendor::where('id', $id)->first();
            $image_path = public_path($vendors->image);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/vendorss/');
            $file->move(public_path('uploads/vendors/'), $fileNameToStore);

             $requestData['image'] = 'uploads/vendors/'.$fileNameToStore;
        }


        $vendor = Vendor::findOrFail($id);
        $vendor->update($requestData);
        return redirect()->back()->with('message', 'Vendor updated!');

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
        Vendor::destroy($id);
        return redirect()->back()->with('message', 'Vendor deleted!');

    }
}
