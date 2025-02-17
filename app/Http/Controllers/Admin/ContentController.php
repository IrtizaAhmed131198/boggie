<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Content;
use App\Chapter;
use Illuminate\Http\Request;
use Image;
use File;

class ContentController extends Controller
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
            $content = Content::with('chapter')->where('content_title', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $content = Content::with('chapter')->get();
        }

        return view('admin.content.index', compact('content'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $chapters = Chapter::all();
        return view('admin.content.create', compact('chapters'));
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
            'chapter_id' => 'required',
            'content_title' => 'required|string|max:255',
            'content_type' => 'required',
            'content_link' => [
                'required_if:content_type,link',
                'nullable',
                'url',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('content_type') == 'link' && !filter_var($value, FILTER_VALIDATE_URL)) {
                        $fail('The content link must be a valid URL.');
                    }
                }
            ],
            'content_file' => [
                'required_if:content_type,document,video',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('content_type') == 'document' || $request->input('content_type') == 'video') {
                        $file = $request->file('content_file');
                        if ($file) {
                            $fileExtension = strtolower($file->getClientOriginalExtension());

                            // Allowed file types for documents
                            $allowedFileTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];

                            // Allowed video types
                            $allowedVideoTypes = ['mp4', 'avi', 'mov', 'mkv', 'flv', 'wmv'];

                            if ($request->input('content_type') == 'document' && !in_array($fileExtension, $allowedFileTypes)) {
                                $fail('Only PDF, DOC, DOCX, XLS, PPT, and text files are allowed.');
                            }

                            if ($request->input('content_type') == 'video' && !in_array($fileExtension, $allowedVideoTypes)) {
                                $fail('Only MP4, AVI, MOV, MKV, FLV, and WMV videos are allowed.');
                            }
                        }
                    }
                }
            ]
        ]);

        $requestData = $request->all();

        // Process file upload if content type is not "link"
        if ($request->input('content_type') != 'link' && $request->hasFile('content_file')) {
            $content = new Content;

            $file = $request->file('content_file');
            $destination_path = 'uploads/content/';
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $profileImage = date("Ymd") . '_' . $fileName . "." . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/content/'), $profileImage);
            $requestData['content_file'] = $destination_path . $profileImage;
        } else {
            // Clear content_file field if content_type is "link"
            $requestData['content_file'] = null;
        }

        Content::create($requestData);
        return redirect('admin/content')->with('message', 'Content added!');
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
        $content = Content::findOrFail($id);
        return view('admin.content.show', compact('content'));
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
        $content = Content::findOrFail($id);
        $chapters = Chapter::all();
        return view('admin.content.edit', compact('content', 'chapters'));
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
            'chapter_id' => 'required',
            'content_title' => 'required|string|max:255',
            'content_type' => 'required',
            'content_link' => [
                'required_if:content_type,link',
                'nullable',
                'url',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('content_type') == 'link' && !filter_var($value, FILTER_VALIDATE_URL)) {
                        $fail('The content link must be a valid URL.');
                    }
                }
            ],
            'content_file' => [
                'nullable',
                'max:2048',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('content_type') == 'document' || $request->input('content_type') == 'video') {
                        $file = $request->file('content_file');
                        if ($file) {
                            $fileExtension = strtolower($file->getClientOriginalExtension());

                            // Allowed file types for documents
                            $allowedFileTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];

                            // Allowed video types
                            $allowedVideoTypes = ['mp4', 'avi', 'mov', 'mkv', 'flv', 'wmv'];

                            if ($request->input('content_type') == 'document' && !in_array($fileExtension, $allowedFileTypes)) {
                                $fail('Only PDF, DOC, DOCX, XLS, PPT, and text files are allowed.');
                            }

                            if ($request->input('content_type') == 'video' && !in_array($fileExtension, $allowedVideoTypes)) {
                                $fail('Only MP4, AVI, MOV, MKV, FLV, and WMV videos are allowed.');
                            }
                        }
                    }
                }
            ]
        ]);

        $requestData = $request->all();

        $content = Content::findOrFail($id);

        // Handle file upload if content type is not "link"
        if ($request->input('content_type') != 'link' && $request->hasFile('content_file')) {
            // Delete old file if it exists
            $content_file_path = public_path($content->content_file);
            if (File::exists($content_file_path)) {
                File::delete($content_file_path);
            }

            // Upload new file
            $file = $request->file('content_file');
            $fileNameExt = $file->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $file->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
            $pathToStore = 'uploads/content/';
            $file->move(public_path($pathToStore), $fileNameToStore);

            $requestData['content_file'] = $pathToStore . $fileNameToStore;
            $requestData['content_link'] = null;  // Clear the link field if uploading a file
        } elseif ($request->input('content_type') == 'link') {
            // Clear content_file field if content type is "link"
            $requestData['content_file'] = null;
        } else {
            // Retain the existing file path if no new file is uploaded
            $requestData['content_file'] = $request->existing_file;
        }

        // Update content with the modified request data
        $content->update($requestData);

        return redirect('admin/content')->with('message', 'Content updated!');
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
        Content::destroy($id);

        return redirect('admin/content')->with('message', 'Content deleted!');
    }
}
