<?php

namespace App\Http\Controllers\Admin;

use DB;
use File;
use Session;
use App\Role;
use App\User;
use Carbon\Carbon;
use App\imagetable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');

        $logo = imagetable::
                     select('img_path')
                     ->where('table_name','=','logo')
                     ->first();

        $favicon = imagetable::
                     select('img_path')
                     ->where('table_name','=','favicon')
                     ->first();

        View()->share('logo',$logo);
        View()->share('favicon',$favicon);

    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (!empty($keyword)) {
            $users = User::where('name', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $users = User::get();
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $roles = Role::select('id', 'name', 'label')->where('id', '!=', 1)->get();
        // $roles = $roles->pluck('name', 'id');
        // $states = DB::table('states')->pluck('name', 'id');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        // dd(123);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'certified' => 'required|string',
        ]);

        // Create a new user instance
        $user = new User;

        // Set user properties
        $user->name = $request->input('name');
        // $user->last_name = $request->input('lname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = 2;
        // $user->address = $request->input('address');
        // $user->state = $request->input('state');
        // $user->city = $request->input('city');
        // $user->zip = $request->input('zip');
        $user->certified = $request->input('certified');
        if($request->input('role') == 3){
            $otp = sprintf('%06d', mt_rand(0, 9999));
            $user->otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->status = 0;

            $emailContent = '<p>Dear ' . $user->name . ',</p>' .
            '<p>Thank you for registering with us. Your OTP for verification is <strong>' . $otp . '</strong>.</p>' .
            '<p>This OTP is valid for 10 minutes. Please use it to verify your email address.</p>' .
            '<p>Best regards,</p>' .
            '<p>Zapgo</p>';

            // Send OTP email
            Mail::send([], [], function ($message) use ($user, $emailContent) {
                $message->to($user->email)
                ->subject('Email Verification OTP')
                ->setBody($emailContent, 'text/html');
            });

            $user->save();
            return redirect('admin/users')->with('flash_message', 'User added Please Verify the account');
        }else{
            $user->status = 1;
            $user->save();
            return redirect('user_management/user_management')->with('flash_message', 'User added!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $roles = Role::select('id', 'name', 'label')->where('id', '!=', 1)->get();
        // $roles = $roles->pluck('name', 'id');

        $users = User::with('roles')->findOrFail($id);
        $user_roles = [];
        foreach ($users->roles as $role) {
            $user_roles[] = $role->name;
        }
        // dd($users);

        // $states = DB::table('states')->pluck('name', 'id');

        return view('admin.users.edit', compact('users', 'roles', 'user_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int      $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id), // Ignore the current user's email
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'certified' => 'required|string',
        ]);

        // Find the user by ID (assuming $userId is the ID of the user being updated)
        $user = User::findOrFail($id);

        // Update user properties
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Update password only if a new one is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->certified = $request->input('certified');

        // Save the updated user to the database
        $user->save();

        return redirect('user_management/user_management')->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        // dd($id);
        if ($user = User::find($id)) {
            // User found, perform delete
            $user->delete();

            // Redirect with success message
            return redirect('user_management/user_management')->with('flash_message', 'User deleted!');
        } else {
            dd('else');
            // If user not found, redirect with error message
            return redirect('user_management/user_management')->with('flash_message', 'User not found!');
        }
    }

    public function getSettings(){
        $user = auth()->user();
        return view('admin.users.account-settings',compact('user'));
    }

    public function saveSettings(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
        ]);

        $user =  auth()->user();

        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();

        $profile = $user->profile;
        if($user->profile == null){
            $profile = new  Profile();
        }
        if($request->dob != null){
            $date =  Carbon::parse($request->dob)->format('Y-m-d');
        }else{
            $date = $request->dob;
        }


        if ($file = $request->file('pic_file')) {
            $extension = $file->extension()?: 'png';
            $destinationPath = public_path() . '/storage/uploads/users/';
            $safeName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $safeName);
            //delete old pic if exists
            if (File::exists($destinationPath . $user->pic)) {
                File::delete($destinationPath . $user->pic);
            }
            //save new file path into db
            $profile->pic = $safeName;
        }


        $profile->user_id = $user->id;
        $profile->bio = $request->bio;
        $profile->gender = $request->gender;
        $profile->dob = $date;
        $profile->country = $request->country;
        $profile->state = $request->state;
        $profile->city = $request->city;
        $profile->address = $request->address;
        $profile->postal = $request->postal;
        $profile->save();

        Session::flash('message','Account has been updated');
        return redirect()->back();
    }

    public function verifyUsers(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|string',
        ]);

        $user = User::find($request->input('user_id'));

        if (!$user || $user->otp != $request->input('otp')) {
            return redirect('admin/users')->with('flash_message', 'Invalid or expired OTP.');
        }
        // if (!$user || $user->otp !== $request->input('otp') || Carbon::now()->greaterThan($user->otp_expires_at)) {
        //     return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        // }

        // OTP is valid; update user status and clear OTP fields
        $user->status = 1;
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect('admin/users')->with('flash_message', 'Account verified. You can now log in.');
    }

}
