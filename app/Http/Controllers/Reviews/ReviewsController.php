<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Review;
use Illuminate\Http\Request;
use Image;
use File;

class ReviewsController extends Controller
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
            $reviews = Review::with('user', 'course')
            ->where('user_id', 'LIKE', "%$keyword%")
            ->orWhere('course_id', 'LIKE', "%$keyword%")
            ->orWhere('rating', 'LIKE', "%$keyword%")
            ->orWhere('comment', 'LIKE', "%$keyword%")
            ->paginate($perPage);
        } else {
            $reviews = Review::with('user', 'course')->paginate($perPage);
        }

        return view('reviews.reviews.index', compact('reviews'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('reviews.reviews.create');

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
        $reviews = new Review($request->all());

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            //make sure yo have image folder inside your public
            $reviews_path = 'uploads/reviewss/';
            $fileName = $file->getClientOriginalName();
            $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

            Image::make($file)->save(public_path($reviews_path) . DIRECTORY_SEPARATOR. $profileImage);

            $reviews->image = $reviews_path.$profileImage;
        }

        $reviews->save();
        return redirect()->back()->with('message', 'Review added!');
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
        $review = Review::findOrFail($id);
        return view('reviews.reviews.show', compact('review'));
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
        $review = Review::findOrFail($id);
        return view('reviews.reviews.edit', compact('review'));
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

            $reviews = Review::where('id', $id)->first();
            $image_path = public_path($reviews->image);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/reviewss/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/reviewss/'.$fileNameToStore;
        }


        $review = Review::findOrFail($id);
        $review->update($requestData);
        return redirect()->back()->with('message', 'Review updated!');

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
        Review::destroy($id);
        return redirect()->back()->with('message', 'Review deleted!');

    }
}
