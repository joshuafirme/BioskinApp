<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variation;
use Auth;

class VariationController extends Controller
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
        $variations = Variation::paginate(10);
        return view('admin.variations.index', compact('variations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.variations.create');
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
            'name' => 'required|unique:variations',
        ]);

        Variation::create($request->all());

        return redirect()->back()
            ->with('success', 'Variation attribute was created.'); $request->validate([
            'name' => 'required|unique:variations',
        ]);
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
    public function edit(Variation $variation)
    {
        return view('admin.variations.edit', compact('variation'));
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
            'name' => 'required:variations',
        ]);

        Variation::where('id', $id)->update(['name' => $request->input('name')]);

        return redirect()->back()
            ->with('success', 'Variation attribute was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variation = Variation::findOrFail($id);
        if ($variation->delete()) {
            return response()->json([
                'status' =>  'success',
                'message' => 'Variation attribute was deleted.'
            ], 200);
        }

        return response()->json([
            'status' =>  'error',
            'message' => 'Deleting failed.'
        ], 200);
    }
}
