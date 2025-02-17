<?php

namespace App\Http\Controllers\subscription_plan;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Subscription_plan;
use Illuminate\Http\Request;
use Image;
use File;

class Subscription_planController extends Controller
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
        $model = str_slug('subscription_plan','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $subscription_plan = Subscription_plan::where('name', 'LIKE', "%$keyword%")
                ->orWhere('price', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $subscription_plan = Subscription_plan::paginate($perPage);
            }

            return view('subscription_plan.subscription_plan.index', compact('subscription_plan'));
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
        $model = str_slug('subscription_plan','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            return view('subscription_plan.subscription_plan.create');
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
        $model = str_slug('subscription_plan','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            

            $subscription_plan = new Subscription_plan($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                
                //make sure yo have image folder inside your public
                $subscription_plan_path = 'uploads/subscription_plans/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

                Image::make($file)->save(public_path($subscription_plan_path) . DIRECTORY_SEPARATOR. $profileImage);

                $subscription_plan->image = $subscription_plan_path.$profileImage;
            }
            
            $subscription_plan->save();
            return redirect()->back()->with('message', 'Subscription_plan added!');
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
        $model = str_slug('subscription_plan','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $subscription_plan = Subscription_plan::findOrFail($id);
            return view('subscription_plan.subscription_plan.show', compact('subscription_plan'));
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
        $model = str_slug('subscription_plan','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $subscription_plan = Subscription_plan::findOrFail($id);
            return view('subscription_plan.subscription_plan.edit', compact('subscription_plan'));
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
        $model = str_slug('subscription_plan','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            
            $requestData = $request->all();
            

        if ($request->hasFile('image')) {
            
            $subscription_plan = Subscription_plan::where('id', $id)->first();
            $image_path = public_path($subscription_plan->image); 
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/subscription_plans/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/subscription_plans/'.$fileNameToStore;               
        }


            $subscription_plan = Subscription_plan::findOrFail($id);
            $subscription_plan->update($requestData);
            return redirect()->back()->with('message', 'Subscription_plan updated!');
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
        $model = str_slug('subscription_plan','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Subscription_plan::destroy($id);
            return redirect()->back()->with('message', 'Subscription_plan deleted!');
        }
        return response(view('403'), 403);

    }
}
