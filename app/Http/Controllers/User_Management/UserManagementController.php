<?php

namespace App\Http\Controllers\User_Management;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\User_two;
use App\User;
use Illuminate\Http\Request;
use Image;
use File;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $status = $request->input('status');

        // Update the status in the database
        $user = User::findOrFail($userId);
        $user->status = $status;
        $user->save();

        return response()->json(['success' => true, 'status' => $user->status]);
    }


    public function updateFeatured(Request $request)
    {
        $userId = $request->input('user_id');
        $featured = $request->input('featured');

        // Update the featured in the database
        $user = User::findOrFail($userId);
        $user->featured = $featured;
        $user->save();

        return response()->json(['success' => true, 'featured' => $user->featured]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('user_management','-');
        // if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null || auth()->user()->role == 1) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {

                if ($keyword == 'active' || $keyword == 'Active') {
                    $user = DB::table('users')->where('status', 1)->where('role', '!=', 1)->get();
                } elseif ($keyword == 'inactive' || $keyword == 'In Active' || $keyword == 'InActive') {
                    $user = DB::table('users')->where('status', 0)->where('role', '!=', 1)->get();
                } else {
                    $user = DB::table('users')->where('name', 'LIKE', "%$keyword%")
                                ->where('role', '!=', 1)
                                ->orWhere('email', 'LIKE', "%$keyword%")
                                ->orWhere('role', 'LIKE', "%$keyword%")
                                ->paginate($perPage);
                }
            } else {
                $user = DB::table('users')->where('role', '!=', 1)->get();
            }

            // dd($user);

            return view('admin.users.index',  compact('user'));
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
        $model = str_slug('user_management','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            return view('user_management.user_management.create');
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
        $model = str_slug('user_management','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            $this->validate($request, [
			'auth_id' => 'required',
			'is_featured' => 'required'
		]);

            $user_two = new User_two($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                //make sure yo have image folder inside your public
                $user_two_path = 'uploads/user_twos/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

                Image::make($file)->save(public_path($user_two_path) . DIRECTORY_SEPARATOR. $profileImage);

                $user_two->image = $user_two_path.$profileImage;
            }

            $user_two->save();
            return redirect()->back()->with('message', 'User_two added!');
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
        $model = str_slug('user_management','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $user_two = User_two::findOrFail($id);
            return view('user_management.user_management.show', compact('user_two'));
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
        // dd(123);
        $model = str_slug('user_management','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $user_two = User_two::findOrFail($id);
            return view('user_management.user_management.edit', compact('user_two'));
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
        $model = str_slug('user_management','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $this->validate($request, [
			'auth_id' => 'required',
			'is_featured' => 'required'
		]);
            $requestData = $request->all();


        if ($request->hasFile('image')) {

            $user_two = User_two::where('id', $id)->first();
            $image_path = public_path($user_two->image);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/user_twos/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/user_twos/'.$fileNameToStore;
        }


            $user_two = User_two::findOrFail($id);
            $user_two->update($requestData);
            return redirect()->back()->with('message', 'User_two updated!');
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
        $model = str_slug('user_management','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            User_two::destroy($id);
            return redirect()->back()->with('message', 'User_two deleted!');
        }
        return response(view('403'), 403);

    }
}
