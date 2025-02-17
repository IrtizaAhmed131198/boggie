<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\orders;
use App\orders_products;
use App\Product;
use App\imagetable;
use App\Attributes;
use App\AttributeValue;
use App\ProductAttribute;
use App\Chapter;
use App\Content;
use App\Jobs\CopyCourseContent;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Image;
use File;
use DB;
use Session;
use DateTime;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {

        $model = str_slug('product', '-');
        if (auth()->user()->permissions()->where('name', '=', 'view-' . $model)->first() != null) {
            // $keyword = $request->get('search');
            // $perPage = 25;

            // if (!empty($keyword)) {
            //     $product = Product::where('products.product_title', 'LIKE', "%$keyword%")
            //         ->leftjoin('categories', 'products.category', '=', 'categories.id')
            //         ->orWhere('products.description', 'LIKE', "%$keyword%")
            //         ->where('products.type', 'course')->whereNotIn('id', [45, 46, 48, 49, 50, 51, 52, 53, 56, 57, 58, 59, 54, 55, 60, 61])
            //         ->orderBy('sort', 'ASC')
            //         ->paginate($perPage);
            // } else {
            //     $product = Product::where('type', 'course')->whereNotIn('id', [45, 46, 48, 49, 50, 51, 52, 53, 56, 57, 58, 59, 54, 55, 60, 61])->orderBy('sort', 'ASC')->paginate($perPage);
            // }

            return view('admin.course.index');
        }
        return response(view('403'), 403);

    }

    public function getIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::where('type', 'course')->orderBy('sort', 'ASC')->get();

            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    // Add row counter
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })
                ->addColumn('category', function ($row) {
                    $category = $row->categorys->name ?? '';
                    return $category;
                })
                ->addColumn('image', function ($row) {
                    $imageUrl = $row->image ? asset($row->image) : null;
                    return $imageUrl ? '<img src="' . $imageUrl . '" width="150">' : 'No Image';
                })
                ->addColumn('status', function ($row) {
                    $btn_class = $row->status == 1 ? 'btn-success' : 'btn-danger';
                    $status = $row->status == 1 ? 'Active' : 'Inactive';
                    $statusButton = '<a href="javascript:void(0)" class="btn btn-sm toggle-status '.$btn_class.'"
                                        data-id="'.$row->id.'">
                                        '.$status.'
                                    </a>';

                    return $statusButton;
                })
                ->addColumn('action', function ($row) {
                    // Add any custom action buttons here
                    $editButton = '<a href="' . url('/admin/course/' . $row->id . '/edit') . '">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                        </button>
                                    </a>';
                    $deleteButton = '<a href="' . route('course.delete', $row->id) . '"
                                        onclick="return confirm(\'Confirm delete?\')">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                        </button>
                                    </a>';


                    return $editButton.$deleteButton;
                })
                ->rawColumns(['id', 'category', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $model = str_slug('product', '-');
        if (auth()->user()->permissions()->where('name', '=', 'add-' . $model)->first() != null) {

            $att = Attributes::all();
            $attval = AttributeValue::all();

            // $items = Category::all(['id', 'name']);
            $items = Category::all(['id', 'name']);

            $course = Product::with('chapters.contents')
                    ->where('id', '!=', $id)
                    ->whereHas('chapters', function ($q) {
                        $q->whereHas('contents');
                    })
                    ->get();

            return view('admin.course.create', compact('items', 'att', 'attval', 'course'));
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
        $model = str_slug('product', '-');
        if (auth()->user()->permissions()->where('name', '=', 'add-' . $model)->first() != null) {
            $this->validate($request, [
                'product_title' => 'required',
                'description' => 'required',
                'price' => 'required',
                'image' => 'required',
                'category' => 'required',
            ]);


            if($request->input('date_range')){
                $date_range = explode(' - ', $request->input('date_range'));
                $string = $date_range[1];
                $date = new DateTime($string);
                $year = $date->format('Y');
            }
            //echo implode(",",$_POST['language']);
            //return;
            $product = new product;

            $product->product_title = $request->input('product_title');
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->category = $request->input('category');
            if ($request->input('category') == 5) {
                $product->year = $year;
            }
            $product->subcategory = $request->input('subcategory');
            $product->type = 'course';
            $product->level = $request->input('level');
            $product->duration = $request->input('duration');
            $product->location = $request->input('location');
            $product->date_range = $request->input('date_range') ?? null;
            $file = $request->file('image');

            //make sure yo have image folder inside your public
            $destination_path = 'uploads/courses/';
            $profileImage = date("Ymdhis") . "." . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/courses/'), $profileImage);
            // Image::make($file)->save(public_path($destination_path) . DIRECTORY_SEPARATOR. $profileImage);

            $product->image = $destination_path . $profileImage;
            $product->save();

            if($product->id){
                $chapter = new Chapter();
                $chapter->course_id = $product->id;
                $chapter->chapter_title = $product->product_title;
                $chapter->save();
            }

            if($request->course_content){
                $courseId = $request->course_content;
                $newChapterId = $chapter->id ?? 0;

                // Dispatch the job
                dispatch(new CopyCourseContent($courseId, $newChapterId));
            }


            if (!is_null(request('images'))) {

                $photos = request()->file('images');
                foreach ($photos as $photo) {
                    $destinationPath = 'uploads/courses/';

                    $filename = date("Ymdhis") . uniqid() . "." . $photo->getClientOriginalExtension();
                    //dd($photo,$filename);
                    $photo->move(public_path('uploads/courses/'), $filename);
                    // Image::make($photo)->save(public_path($destinationPath) . DIRECTORY_SEPARATOR. $filename);

                    DB::table('product_imagess')->insert([

                        ['image' => $destination_path . $filename, 'product_id' => $product->id]

                    ]);

                }

            }
            //$photos->save();
            //$requestData = $request->all();
            //Product::create($requestData);

            $attval = $request->attribute;

            if(is_array($attva)){
                for ($i = 0; $i < count($attval); $i++) {
                    $product_attributes = new ProductAttribute;
                    $product_attributes->attribute_id = $attval[$i]['attribute_id'];
                    $product_attributes->value = $attval[$i]['value'];
                    $product_attributes->price = $attval[$i]['v-price'];
                    $product_attributes->qty = $attval[$i]['qty'];
                    $product_attributes->product_id = $product->id;

                    $product_attributes->save();
                }
            }

            return redirect('admin/course')->with('message', 'Course added!');
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
        $model = str_slug('product', '-');
        if (auth()->user()->permissions()->where('name', '=', 'view-' . $model)->first() != null) {
            $product = Product::findOrFail($id);
            return view('admin.course.show', compact('product'));
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
        $model = str_slug('product', '-');

        $att = Attributes::all();
        $product = Product::findOrFail($id);

        $items = Category::all(['id', 'name']);

        $course = Product::with('chapters.contents')
                    ->where('id', '!=', $id)
                    ->whereHas('chapters', function ($q) {
                        $q->whereHas('contents');
                    })
                    ->get();

        $product_images = DB::table('product_imagess')
            ->where('product_id', $id)
            ->get();

        return view('admin.course.edit', compact('product', 'items', 'product_images', 'att', 'course'));
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
        $model = str_slug('product', '-');
        if (auth()->user()->permissions()->where('name', '=', 'edit-' . $model)->first() != null) {
            $this->validate($request, [
                'product_title' => 'required',
                'description' => 'required',
                'category' => 'required'
            ]);

            $date_range = explode(' - ', $request->input('date_range'));
            $string = $date_range[1];
            $date = new DateTime($string);
            $year = $date->format('Y');

            $requestData['product_title'] = $request->input('product_title');
            $requestData['description'] = $request->input('description');
            $requestData['sku'] = $request->input('sku');
            $requestData['price'] = $request->input('price');
            $requestData['category'] = $request->input('category');
            if ($request->input('category') == 5) {
                $requestData['year'] = $year;
            }
            $requestData['subcategory'] = $request->input('subcategory');
            $requestData['level'] = $request->input('level');
            $requestData['duration'] = $request->input('duration');
            $requestData['date_range'] = $request->input('date_range');
            $requestData['location'] = $request->input('location');

            // dump($request->input());
            // die();
            /*Insert your data*/

            // Detail::insert( [
            // 'images'=>  implode("|",$images),
            // ]);

            if ($request->hasFile('image')) {

                $product = product::where('id', $id)->first();
                $image_path = public_path($product->image);

                if (File::exists($image_path)) {

                    File::delete($image_path);
                }

                $file = $request->file('image');
                $fileNameExt = $request->file('image')->getClientOriginalName();
                $fileNameForm = str_replace(' ', '_', $fileNameExt);
                $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
                $fileExt = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $fileExt;
                $pathToStore = public_path('uploads/courses/');
                $file->move(public_path('uploads/courses/'), $fileNameToStore);
                // Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

                $requestData['image'] = 'uploads/courses/' . $fileNameToStore;
            }

            if (!is_null(request('images'))) {

                $photos = request()->file('images');
                foreach ($photos as $photo) {
                    $destinationPath = 'uploads/courses/';

                    $filename = date("Ymdhis") . uniqid() . "." . $photo->getClientOriginalExtension();
                    //dd($photo,$filename);
                    $photo->move(public_path('uploads/courses/'), $filename);
                    // Image::make($photo)->save(public_path($destinationPath) . DIRECTORY_SEPARATOR. $filename);

                    $product = product::where('id', $id)->first();

                    DB::table('product_imagess')->insert([

                        ['image' => $destinationPath . $filename, 'product_id' => $product->id]

                    ]);

                }

            }

            product::where('id', $id)
                ->update($requestData);

            $chapter = Chapter::where('course_id', $id)->first();
            if ($chapter) {
                $chapter->chapter_title = $request->input('product_title');
                $chapter->save();
            } else {
                $chapter = new Chapter();
                $chapter->course_id = $id;
                $chapter->chapter_title = $request->input('product_title');
                $chapter->save();
            }

            if($request->course_content){
                $courseId = $request->course_content;
                $newChapterId = $chapter->id ?? 0;
                Content::where('chapter_id', $chapter->id)->delete();

                // Dispatch the job
                dispatch(new CopyCourseContent($courseId, $newChapterId));
            }


            $attval = $request->attribute;
            $product_attribute_id = $request->product_attribute;
            $oldatt = $request->attribute_id;
            $oldval = $request->value;
            $oldprice = $request->v_price;
            $oldqty = $request->qty;

            if(is_array($oldatt)){
                for ($j = 0; $j < count($oldatt); $j++) {
                    $product_attribute = ProductAttribute::find($product_attribute_id[$j]);
                    $product_attribute->attribute_id = $oldatt[$j];
                    $product_attribute->value = $oldval[$j];
                    $product_attribute->price = $oldprice[$j];
                    $product_attribute->qty = $oldqty[$j];
                    $product_attribute->save();
                }
            }

            if(is_array($attval)){

                for ($i = 0; $i < count($attval); $i++) {
                    $product_attributes = new ProductAttribute;
                    $product_attributes->attribute_id = $attval[$i]['attribute_id'];
                    $product_attributes->value = $attval[$i]['value'];
                    $product_attributes->price = $attval[$i]['v-price'];
                    $product_attributes->qty = $attval[$i]['qty'];
                    $product_attributes->product_id = $id;
                    $product_attributes->save();
                }
            }

            /*
           if(! is_null(request('images'))) {


                   DB::table('product_imagess')->where('product_id', '=', $id)->delete();

                   $photos=request()->file('images');



                   foreach ($photos as $photo) {
                       $destinationPath = 'uploads/courses/';

                       $fileName = uniqid() . "_" . $file->getClientOriginalName();
                       $file->move(storage_path($destinationPath), $fileName);


                       DB::table('product_imagess')->insert([

                           ['image' => $destinationPath.$filename, 'product_id' => $product->id]

                       ]);

                   }

           }
           */

            return redirect('admin/course')->with('message', 'Course updated!');
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
        $model = str_slug('product', '-');
        if (auth()->user()->permissions()->where('name', '=', 'delete-' . $model)->first() != null) {
            $product = Product::findOrFail($id);
            foreach ($product->chapters as $chapter) {
                $chapter->contents()->delete();
            }
            $product->chapters()->delete();
            $product->delete();

            return redirect('admin/course')->with('flash_message', 'Course deleted!');
        }
        return response(view('403'), 403);

    }
    public function orderList()
    {

        $orders = orders::
            select('orders.*')
            ->get();

        return view('admin.ecommerce.order-list', compact('orders'));
    }

    public function orderListDetail($id)
    {

        $order_id = $id;
        $order = orders::where('id', $order_id)->first();
        $order_products = orders_products::where('orders_id', $order_id)->get();



        return view('admin.ecommerce.order-page')->with('title', 'Invoice #' . $order_id)->with(compact('order', 'order_products'))->with('order_id', $order_id);

        // return view('admin.ecommerce.order-page');
    }

    public function updatestatuscompleted($id)
    {

        $order_id = $id;
        $order = DB::table('orders')
            ->where('id', $id)
            ->update(['order_status' => 'Completed']);


        Session::flash('message', 'Order Status Updated Successfully');
        Session::flash('alert-class', 'alert-success');
        return back();

    }
    public function updatestatusPending($id)
    {

        $order_id = $id;
        $order = DB::table('orders')
            ->where('id', $id)
            ->update(['order_status' => 'Pending']);


        Session::flash('message', 'Order Status Updated Successfully');
        Session::flash('alert-class', 'alert-success');
        return back();

    }

    public function set_sub_category()
    {

        $get_id = $_GET['get_id'];

        //  dd("Hello");

        $getsub_category = Subcategory::where(['category' => $get_id])->get();

        //    dd($getsub_category);

        return response()->json(['status' => 'true', 'message' => 'subcategory', 'getsub_category' => $getsub_category]);

    }

    public function course_status($id)
    {
        $item = Product::findOrFail($id);
        $item->status = !$item->status;
        $item->save();

        return response()->json([
            'status' => 'success',
            'data' => [
                'status' => $item->status
            ]
        ]);
    }


    public function move(Request $request)
    {
        $id = $request->input('id');
        $direction = $request->input('direction');

        $course = Product::find($id);

        if (!$course) {
            return response()->json(['success' => false]);
        }

        if ($direction === 'up') {
            $swapCourse = Product::where('sort', '<', $course->sort)
                ->where('type', 'course')
                ->orderBy('sort', 'desc')
                ->first();
        } else {
            $swapCourse = Product::where('sort', '>', $course->sort)
                ->where('type', 'course')
                ->orderBy('sort', 'asc')
                ->first();
        }

        if ($swapCourse) {
            // Swap sort values
            $temp = $course->sort;
            $course->sort = $swapCourse->sort;
            $swapCourse->sort = $temp;

            // Save changes
            $course->save();
            $swapCourse->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

}
