<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use App\inquiry;
use App\newsletter;
use App\Program;
use App\imagetable;
use App\Banner;
use App\User;
use App\Profile;
use App\Models\Subscription_plan;
use App\Models\Audio_gallery;
use App\Models\Gallery_picture;
use App\Models\Favorite_dj;
use App\Models\Artist;
use App\Models\Music_event;
use DB;
use View;
use File;
use App\orders_products;
use Auth;
use Session;
use App\Http\Traits\HelperTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class LoggedInController extends Controller
{
	use HelperTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 // use Helper;

    public function __construct()
    {

		// $this->middleware('guest');
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
        //View()->share('config',$config);
    }

	public function profile()
    {
        $page = DB::table('pages')->where('id', 2)->first();
        $users = User::find(Auth::user()->id);
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        $audio = Audio_gallery::where('auth_id', Auth::user()->id)->get();
        $gallery = Gallery_picture::where('auth_id', Auth::user()->id)->get();
        $favorite = Favorite_dj::with('dj','dj_profile','type')->where('auth_id', Auth::user()->id)->get();
        $events = Music_event::with('auth')->where('auth_id', Auth::user()->id)->get();

        return view('profile', compact('page', 'users', 'profile', 'audio', 'gallery', 'favorite', 'events'));
    }


	public function audio()
    {
		$data = Audio_gallery::where('auth_id', Auth::user()->id)->get();
		return view('account.audio.index', compact('data'));
	}

	public function create_audio()
    {
		return view('account.audio.create');
	}

	public function audio_store(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'audio_title' => 'required',
            'description' => 'required',
            'language' => 'required',
            'genre' => 'required',
            'free_style_name' => 'required',
			'price' => 'required',
            'file' => 'required|mimes:mp3,wav',
            'image' => 'required|mimes:png,jpeg,gif,jpg,jfif,pjpeg,pjp,svg',
        ]);

		if ($validator->fails()) {
			return redirect()->back()->with('error', 'Validation Error!');
		}

		if ($request->hasFile('image')) {
			$audio = $request->file('image');
            $imagename = time() . '_' . $audio->getClientOriginalName();
            $path = $audio->move(public_path('audio_pictures'), $imagename);
		}else{
			$imagename = '';
		}

		if ($request->hasFile('file')) {
            $audio = $request->file('file');
            $filename = time() . '_' . $audio->getClientOriginalName();
            $path = $audio->move(public_path('audio_file'), $filename);


            Audio_gallery::create([
				'audio_title' => $request->audio_title,
				'description' => $request->description,
				'language' => $request->language,
				'genre' => $request->genre,
				'price' => $request->price,
				'free_style_name' => $request->free_style_name,
				'file' => 'audio_file/'.$filename,
				'image' => ($imagename != '') ? 'audio_pictures/'.$imagename : null,
				'auth_id' => Auth::user()->id
			]);

            return redirect()->back()->with('success', 'Audio Uploaded Successfully');
        }else{
			return redirect()->back()->with('error', 'Audio Uploaded Failed!');
		}
	}

	public function audio_update(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'audio_id' => 'required',
            'audio_title' => 'required',
            'description' => 'required',
            'language' => 'required',
			'genre' => 'required',
            'free_style_name' => 'required',
            'price' => 'required',
            'file' => 'nullable|mimes:mp3,wav',
            'image' => 'nullable|mimes:png,jpeg,gif,jpg,jfif,pjpeg,pjp,svg',
        ]);

		if ($validator->fails()) {
			return redirect()->back()->with('error', 'Validation Error!');
		}

		$data = Audio_gallery::find($request->audio_id);

		if (!$data) {
			return redirect()->back()->with('error', 'Audio not found');
		}

		if ($request->hasFile('image')) {
			$audio = $request->file('image');
            $imagename = time() . '_' . $audio->getClientOriginalName();
            $path = $audio->move(public_path('audio_pictures'), $imagename);
			$i_path = 'audio_pictures/'.$imagename;

			if (isset($data->image) && file_exists(public_path($data->image))) {
				unlink(public_path($data->image));
			}
		}else{
			$i_path = $request->old_image;
		}

		if ($request->hasFile('file')) {
            $audio = $request->file('file');
            $filename = time() . '_' . $audio->getClientOriginalName();
            $path = $audio->move(public_path('audio_file'), $filename);
			$f_path = 'audio_file/'.$filename;

			if (isset($data->file) && file_exists(public_path($data->file))) {
				unlink(public_path($data->file));
			}
		}else{
			$f_path = $request->old_file;
		}

		$data->update([
			'audio_title' => $request->audio_title,
			'description' => $request->description,
			'language' => $request->language,
			'genre' => $request->genre,
			'price' => $request->price,
			'free_style_name' => $request->free_style_name,
			'file' => $f_path,
			'image' => $i_path,
			'auth_id' => Auth::user()->id
		]);

        return redirect()->back()->with('success', 'Audio Uploaded Successfully');
	}

	public function audio_delete($id)
	{
		$data = Audio_gallery::find($id);

		if (!$data) {
			return redirect()->back()->with('error', 'Audio not found');
		}

		if (isset($data->file) && file_exists(public_path($data->file))) {
			if (unlink(public_path($data->file))) {

				if (isset($data->image) && file_exists(public_path($data->image))) {
					if (unlink(public_path($data->image))) {

						$data->delete();
						return redirect()->back()->with('success', 'Audio and associated image deleted successfully');
					} else {
						return redirect()->back()->with('error', 'Failed to delete associated image file');
					}
				}

				$data->delete();
				return redirect()->back()->with('success', 'Audio deleted successfully');
			} else {
				return redirect()->back()->with('error', 'Failed to delete audio file');
			}
		} else {
			return redirect()->back()->with('error', 'Audio file not found');
		}
	}



	public function gallery()
    {
		$data = Gallery_picture::where('auth_id', Auth::user()->id)->get();
		return view('account.gallery.index', compact('data'));
	}

	public function gallery_store(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'description' => 'required',
            'image' => 'required|mimes:png,jpeg,gif,jpg,jfif,pjpeg,pjp,svg',
        ]);

		if ($validator->fails()) {
			return redirect()->back()->with('error', 'Validation Error!');
		}

		if ($request->hasFile('image')) {
            $gallery = $request->file('image');
            $filename = time() . '_' . $gallery->getClientOriginalName();
            $path = $gallery->move(public_path('gallery_pictures'), $filename);


            Gallery_picture::create([
				'description' => $request->description,
				'image' => 'gallery_pictures/'.$filename,
				'auth_id' => Auth::user()->id
			]);

            return redirect()->back()->with('success', 'Picture Uploaded Successfully');
        }else{
			return redirect()->back()->with('error', 'Picture Uploaded Failed!');
		}
	}

	public function gallery_update(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'gallery_id' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpeg,gif,jpg,jfif,pjpeg,pjp,svg,avif',
        ]);

		if ($validator->fails()) {
			return redirect()->back()->with('error', 'Validation Error!');
		}

		$data = Gallery_picture::find($request->gallery_id);

		if (!$data) {
			return redirect()->back()->with('error', 'Picture not found');
		}

		if ($request->hasFile('image')) {
			if (isset($data->image) && file_exists(public_path($data->image))) {
				unlink(public_path($data->image));
			}
            $gallery = $request->file('image');
            $filename = time() . '_' . $gallery->getClientOriginalName();
            $path = $gallery->move(public_path('gallery_pictures'), $filename);
			$f_path = 'gallery_pictures/'.$filename;

		}else{
			$f_path = $request->old_image;
		}

		$data->update([
			'description' => $request->description,
			'image' => $f_path,
			'auth_id' => Auth::user()->id
		]);

        return redirect()->back()->with('success', 'Picture Uploaded Successfully');
	}

	public function gallery_delete($id)
	{
		$data = Gallery_picture::find($id);

		if (!$data) {
			return redirect()->back()->with('error', 'Picture not found');
		}

		if (isset($data->image) && file_exists(public_path($data->image))) {
			if (unlink(public_path($data->image))) {
				$data->delete();
				return redirect()->back()->with('success', 'Picture Delete Successfully');
			} else {
				return redirect()->back()->with('error', 'Failed to delete file');
			}
		} else {
			return redirect()->back()->with('error', 'File not found');
		}
	}

	public function get_artist($id)
	{
		$artists = User::where('artist_type', $id)->where('id', '!=', Auth::user()->id)->select('id', 'name')->get();
		return $artists;
	}

	public function favorite()
    {
		$data = Favorite_dj::with('dj','type')->where('auth_id', Auth::user()->id)->get();
		$artist_type = Artist::all();
		$artist = User::where('id', '!=', Auth::user()->id)
			->where('role', 2)
			->whereNotNull('subscription_id')
			->get();
		return view('account.favorite.index', compact('data', 'artist', 'artist_type'));
	}

	public function favorite_store(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'artist' => 'required',
            'artist_type' => 'required',
        ]);

		if ($validator->fails()) {
			return redirect()->back()->with('error', 'Validation Error!');
		}

		Favorite_dj::create([
			'dj_id' => $request->artist,
			'artist_type' => $request->artist_type,
			'auth_id' => Auth::user()->id
		]);

        return redirect()->back()->with('success', 'Add Favourite Successfully');
	}

	public function favorite_delete($id)
	{
		$data = Favorite_dj::find($id);

		if (!$data) {
			return redirect()->back()->with('error', 'Picture not found');
		}

		$data->delete();
		return redirect()->back()->with('success', 'Remove Favourite Successfully');
	}

	public function event()
    {
		$data = Music_event::where('auth_id', Auth::user()->id)->get();
		return view('account.event.index', compact('data'));
	}

	public function event_store(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'event_title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'image' => 'required|mimes:png,jpeg,gif,jpg,jfif,pjpeg,pjp,svg',
        ]);

		if ($validator->fails()) {
			return redirect()->back()->with('error', 'Validation Error!');
		}

		if ($request->hasFile('image')) {
            $event = $request->file('image');
            $filename = time() . '_' . $event->getClientOriginalName();
            $path = $event->move(public_path('event_pictures'), $filename);


            Music_event::create([
				'event_title' => $request->event_title,
				'description' => $request->description,
				'location' => $request->location,
				'event_date' => $request->event_date,
				'event_time' => $request->event_time,
				'image' => 'event_pictures/'.$filename,
				'auth_id' => Auth::user()->id
			]);

            return redirect()->back()->with('success', 'Event Created Successfully');
        }else{
			return redirect()->back()->with('error', 'Event Created Failed!');
		}
	}

	public function event_update(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'event_id' => 'required',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'image' => 'nullable|mimes:png,jpeg,gif,jpg,jfif,pjpeg,pjp,svg',
        ]);

		if ($validator->fails()) {
			return redirect()->back()->with('error', 'Validation Error!');
		}

		$data = Music_event::find($request->event_id);

		if (!$data) {
			return redirect()->back()->with('error', 'Event not found');
		}

		if ($request->hasFile('image')) {
			if (isset($data->image) && file_exists(public_path($data->image))) {
				unlink(public_path($data->image));
			}
            $event = $request->file('image');
            $filename = time() . '_' . $event->getClientOriginalName();
            $path = $event->move(public_path('event_pictures'), $filename);
			$f_path = 'event_pictures/'.$filename;

		}else{
			$f_path = $request->old_image;
		}

		$data->update([
			'event_title' => $request->event_title,
			'description' => $request->description,
			'location' => $request->location,
			'event_date' => $request->event_date,
			'event_time' => $request->event_time,
			'image' => 'event_pictures/'.$filename,
			'auth_id' => Auth::user()->id
		]);

        return redirect()->back()->with('success', 'Event Updated Successfully');
	}

	public function event_delete($id)
	{
		$data = Music_event::find($id);

		if (!$data) {
			return redirect()->back()->with('error', 'Event not found');
		}

		if (isset($data->image) && file_exists(public_path($data->image))) {
			if (unlink(public_path($data->image))) {
				$data->delete();
				return redirect()->back()->with('success', 'Event Delete Successfully');
			} else {
				return redirect()->back()->with('error', 'Failed to delete file');
			}
		} else {
			return redirect()->back()->with('error', 'File not found');
		}
	}
}

