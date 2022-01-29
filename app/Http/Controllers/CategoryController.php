<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subategory;
use Auth;
use Cache;

class CategoryController extends Controller
{
    private $page = "Maintenance";

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
            if (Auth::check()) {
                $allowed_pages = explode(",",Auth::user()->allowed_pages);
                if (!in_array($this->page, $allowed_pages)) {
                    return redirect('/not-auth');
                }
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::paginate(10);

        return view('admin.category.index', compact('category'));
    }

    public function readCategory($id)
    {
        return Category::select('name', 'wording')->where('id', $id)->first();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name' => 'required|unique:category',
        ]);
    
        $input = $request->all();

        if($request->hasFile('image')){       
            $folder_to_save = 'categories';
            $image_name = uniqid() . "." . $request->image->extension();
            $request->image->move(public_path('images/' . $folder_to_save), $image_name);
            $input['image'] = $folder_to_save . "/" . $image_name;
        }

        Category::create($input);

        Cache::forget('categories-cache');

        return redirect()->back()
            ->with('success', 'category was created.');
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
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
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
            'name' => 'required:category',
        ]);

        $input = $request->except(['_token', '_method']);

        if($request->hasFile('image')){    
            $folder_to_save = 'categories';
            $image_name = uniqid() . "." . $request->image->extension();
            $request->image->move(public_path('images/' . $folder_to_save), $image_name);
            $input['image'] = $folder_to_save . "/" . $image_name;
        }

        Category::where('id', $id)->update($input);

        Cache::forget('categories-cache');

        return redirect()->back()
            ->with('success', 'Category was updated.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id',$id)->update(['status'=> 0]);
        return response()->json([
            'status' =>  'success',
            'message' => 'Category was archived.'
        ], 200);
    }
}
