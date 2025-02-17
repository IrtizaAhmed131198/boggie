<?php

namespace App\Http\Controllers\Accreditations;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Accreditation;
use Illuminate\Http\Request;
use Image;
use File;

class AccreditationsController extends Controller
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
        $model = str_slug('accreditations','-');
        // if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $accreditations = Accreditation::where('title', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('image', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $accreditations = Accreditation::paginate($perPage);
            }

            return view('accreditations.accreditations.index', compact('accreditations'));
            // }
            // return response(view('403'), 403);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = str_slug('accreditations','-');
        // if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            return view('accreditations.accreditations.create');
        // }
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
        $model = str_slug('accreditations','-');
        // if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {


            $accreditations = new Accreditation($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                //make sure yo have image folder inside your public
                $accreditations_path = 'uploads/accreditationss/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

                $file->move(public_path('uploads/accreditations/'), $fileNameToStore);

                $accreditations->image = $accreditations_path.$profileImage;
            }


            $accreditations->save();
            return redirect()->back()->with('message', 'Accreditation added!');
        // }
        // return response(view('403'), 403);
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
        $model = str_slug('accreditations','-');
        // if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $accreditation = Accreditation::findOrFail($id);
            return view('accreditations.accreditations.show', compact('accreditation'));
        // }
        // return response(view('403'), 403);
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
        $model = str_slug('accreditations','-');
        // if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $accreditation = Accreditation::findOrFail($id);
            return view('accreditations.accreditations.edit', compact('accreditation'));
        // }
        // return response(view('403'), 403);
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
        $model = str_slug('accreditations','-');
        // if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {

            $requestData = $request->all();


        if ($request->hasFile('image')) {

            $accreditations = Accreditation::where('id', $id)->first();
            $image_path = public_path($accreditations->image);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/accreditationss/');
            $file->move(public_path('uploads/accreditationss/'), $fileNameToStore);
            // Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/accreditationss/'.$fileNameToStore;
        }


            $accreditation = Accreditation::findOrFail($id);
            $accreditation->update($requestData);
            return redirect()->back()->with('message', 'Accreditation updated!');
        // }
        // return response(view('403'), 403);

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
        $model = str_slug('accreditations','-');
        // if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Accreditation::destroy($id);
            return redirect()->back()->with('message', 'Accreditation deleted!');
        // }
        // return response(view('403'), 403);

    }
}
