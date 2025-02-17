<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Chapter;
use App\Product;
use Illuminate\Http\Request;
use Image;
use File;

class ChaptersController extends Controller
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
            $chapter = Chapter::with('course')->where('chapter_title', 'LIKE', "%$keyword%")
            ->orWhere('chapter_number', 'LIKE', "%$keyword%")
            ->paginate($perPage);
        } else {
            $chapter = Chapter::with('course')->paginate($perPage);
        }

        return view('admin.chapter.index', compact('chapter'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $course = Product::whereIn('category', [1,5])->get();
        return view('admin.chapter.create', compact('course'));
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
        $this->validate($request, [
            'course_id' => 'required',
            'chapter_title' => 'required',
        ]);
        $requestData = $request->all();

        //
        //Chapter::create($requestData);

        Chapter::create($requestData);
        return redirect('admin/chapter')->with('flash_message', 'Chapter added!');
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
        $chapter = Chapter::findOrFail($id);
        return view('admin.chapter.show', compact('chapter'));
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
        $chapter = Chapter::findOrFail($id);
        $course = Product::whereIn('category', [1,5])->get();
        return view('admin.chapter.edit', compact('chapter', 'course'));
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
        $this->validate($request, [
            'name' => 'required'
        ]);
        $requestData = $request->all();


        if ($request->hasFile('image')) {

            $chapter = Chapter::where('id', $id)->first();
            $image_path = public_path($chapter->image);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/chapter/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

            $requestData['image'] = 'uploads/categorys/'.$fileNameToStore;
        }


        $chapter = Chapter::findOrFail($id);
        $chapter->update($requestData);

        return redirect('admin/chapter')->with('flash_message', 'Chapter updated!');

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
        Chapter::destroy($id);

        return redirect('admin/chapter')->with('flash_message', 'Chapter deleted!');

    }
}
