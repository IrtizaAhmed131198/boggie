<?php

namespace App\Http\Controllers\Staff;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Staff;
use Illuminate\Http\Request;
use Image;
use File;

class StaffController extends Controller
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
        $model = str_slug('staff','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $staff = Staff::where('name', 'LIKE', "%$keyword%")
                ->orWhere('position', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $staff = Staff::paginate($perPage);
            }

            return view('staff.staff.index', compact('staff'));
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
        $model = str_slug('staff','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            return view('staff.staff.create');
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
        $model = str_slug('staff','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {


            $staff = new Staff($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                //make sure yo have image folder inside your public
                $staff_path = 'uploads/staffs/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

                $file->move(public_path('uploads/staffs/'), $profileImage);

                $staff->image = $staff_path.$profileImage;
            }

            $staff->save();
            return redirect()->back()->with('message', 'Staff added!');
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
        $model = str_slug('staff','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $staff = Staff::findOrFail($id);
            return view('staff.staff.show', compact('staff'));
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
        $model = str_slug('staff','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $staff = Staff::findOrFail($id);
            return view('staff.staff.edit', compact('staff'));
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
        $model = str_slug('staff','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {

            $requestData = $request->all();


        if ($request->hasFile('image')) {

            $staff = Staff::where('id', $id)->first();
            $image_path = public_path($staff->image);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/staffs/');
            $file->move(public_path('uploads/staffs/'), $profileImage);

             $requestData['image'] = 'uploads/staffs/'.$fileNameToStore;
        }


            $staff = Staff::findOrFail($id);
            $staff->update($requestData);
            return redirect()->back()->with('message', 'Staff updated!');
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
        $model = str_slug('staff','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Staff::destroy($id);
            return redirect()->back()->with('message', 'Staff deleted!');
        }
        return response(view('403'), 403);

    }
}
