<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packaging;

class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packaging = Packaging::paginate(10);
        return view('admin.packaging.index', compact('packaging'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packaging.create');
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
            'name' => 'required|unique:packaging',
        ]);

        Packaging::create($request->all());

        return redirect()->back()
            ->with('success', 'Packaging was created.'); $request->validate([
            'name' => 'required|unique:packaging',
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
    public function edit(Packaging $packaging)
    {
        return view('admin.packaging.edit', compact('packaging'));
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
            'name' => 'required:packaging',
        ]);

        Packaging::where('id', $id)->update(['name' => $request->input('name')]);

        return redirect()->back()
            ->with('success', 'Packaging name was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $packaging = Packaging::findOrFail($id);
        if ($packaging->delete()) {
            return response()->json([
                'status' =>  'success',
                'message' => 'Packaging was deleted.'
            ], 200);
        }

        return response()->json([
            'status' =>  'error',
            'message' => 'Deleting packaging failed.'
        ], 200);
    }
}
