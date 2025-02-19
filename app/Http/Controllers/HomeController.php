<?php

namespace App\Http\Controllers;
use App\banner;
use App\Certificate;
use App\Content;
use App\Http\Helpers\UserSystemInfoHelper;
use App\Http\Traits\HelperTrait;
use App\imagetable;
use App\Inquiry;
use App\Models\Accreditation;
use App\Models\Audio_gallery;
use App\Models\Music_event;
use App\Models\Music_news;
use App\Models\Review;
use App\Models\Vendor;
use App\Newsletter;
use App\orders;
use App\Package;
use App\Page;
use App\post;
use App\Product;
use App\Profile;
use App\schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use Mail;
use PDF;
use Session;
use View;

class HomeController extends Controller
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
        //$this->middleware('auth');

        $logo = imagetable::
            select('img_path')
            ->where('table_name', '=', 'logo')
            ->first();

        $favicon = imagetable::
            select('img_path')
            ->where('table_name', '=', 'favicon')
            ->first();

        View()->share('logo', $logo);
        View()->share('favicon', $favicon);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $page = DB::table('pages')->where('id', 1)->first();
        $section = DB::table('section')->where('page_id', 1)->get();
        $logo = DB::table('logos')->pluck('image');
        $address = DB::table('m_flag')->pluck('flag_value');
        $images = DB::table('gallery')->where('status', 'approved')->get();
        // dd($images);
        
        return view('welcome', compact('page', 'section', 'logo', 'address' , 'images'));

    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        $page = DB::table('pages')->where('id', 1)->first();

        $audio = Audio_gallery::with('auth')
            ->where('audio_title', 'LIKE', "%{$query}%")
            ->orderBy('id', 'desc')
            ->limit(12)
            ->get();

        $audio_list = Audio_gallery::with('auth')->where('hot_list', 1)->orderBy('id', 'desc')->limit(10)->get();

        $events = Music_event::with('auth')->orderBy('event_date', 'desc')->limit(5)->get();

        $artist = User::with('profile')->where('role', 2)->where('featured', 1)->orderBy('id', 'desc')->limit(5)->get();

        $recent_artist = User::with('profile')->where('role', 2)->orderBy('id', 'desc')->limit(5)->get();

        $news = Music_news::with('auth')->orderBy('id', 'desc')->limit(5)->get();

        return view('welcome', compact('page', 'audio', 'audio_list', 'events', 'artist', 'recent_artist', 'news'));
    }


    public function thebooth()
    {
        $page = DB::table('pages')->where('id', 3)->first();

        $users = User::find(Auth::user()->id);
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        $audio = Audio_gallery::with('auth')->orderBy('id', 'desc')->limit(10)->get();

        $maxStars = Audio_gallery::max('stars');

        $audio_latest_max_stars = Audio_gallery::with('auth')
            ->where('stars', $maxStars)
            ->orderBy('id', 'desc')
            ->first();

        return view('thebooth', compact('page', 'users', 'profile', 'audio', 'audio_latest_max_stars'));
    }


    public function contact()
    {
        return view('contact');
    }

    public function about()
    {

        return view('about');
    }


    public function trc()
    {
        return view('certificate.TR-C');
    }
    public function fpc()
    {
        return view('certificate.FP-C');
    }
    public function tpc()
    {
        return view('certificate.TP-C');
    }


    
    public function content()
    {
        return view('home_con.add_content', compact('youtube'));
    }

    // public function upload_content(Request $request)
    // {
    //     dd(123);
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $imagePath = $request->file('image')->store('uploads', 'public');

    //     content::create([
    //         'image' => $imagePath,
    //     ]);

    //     return redirect()->back()->with('success', 'Done successfully!');
    // }
}
