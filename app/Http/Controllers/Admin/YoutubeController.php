<?php

namespace App\Http\Controllers\Admin;

use App\Models\youtube;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class YoutubeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $youtube = DB::table('youtube')->get();
        // dd($youtube);
        return view('admin.youtube.index', compact('youtube'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.youtube.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required',
        ]);

        $youtube = youtube::create([
            'link' => $request->input('link'),
        ]);

        return redirect()->route('admin.youtube.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch the YouTube link by ID
        $youtube = DB::table('youtube')->where('id', $id)->first();

        // Pass the data to the edit view
        return view('admin.youtube.edit', compact('youtube'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'link' => 'required|string',
        ]);

        // Update the record in the database
        DB::table('youtube')->where('id', $id)->update([
            'link' => $request->input('link'),
        ]);

        // Redirect back with a success message
        return redirect()->route('admin.youtube.edit', $id)->with('success', 'media updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($youtube = youtube::find($id)) {
            // youtube found, perform delete
            $youtube->delete();

            // Redirect with success message
            return redirect()->route('admin.youtube.index')->with('flash_message', 'media deleted!');
        } else {
            dd('else');
            // If user not found, redirect with error message
            return redirect()->route('admin.youtube.index')->with('flash_message', 'media not found!');
        }
    }
}
