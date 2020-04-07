<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['info'] = array();
        $categories = Category::select('_id', 'title', 'status', 'image', 'created_at', 'type');

        if(request()->ajax()) {
            
            if($request->get('parent_id')) {
                $categories->where('parent_id', $request->get('parent_id'));
            } else {
                $categories->where('parent_id', null);
            }
            return datatables()->of($categories->get())
                ->addIndexColumn()
                ->addColumn('action', 'admin.category.action')
                ->editColumn('status', 'admin.category.status')
                ->editColumn('image', 'admin.category.image')
                ->rawColumns(['status', 'action', 'image'])
                ->make(true);
        } else {
            if($request->get('parent_id')) {
                $categories->where('_id', $request->get('parent_id'));
                $data['info'] = $categories->first();
            }
        }
        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $insert = [
            "title" => $request->get('title'),
            "type" =>  $request->get('type'),
            "parent_id" =>  $request->get('parent_id')
        ];

        if ($files = $request->file('image')) {
           $destinationPath = 'asset/category/'; // upload path
           $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profilefile);
           $insert['image'] = $profilefile;
        }

        $status = Category::create($insert);
        if($status) {
            return response()->success('Category has been added successfully');
        }
        return response()->fail('Oops! Something went wrong');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $update = [
            "title" => $request->get('title'),
            "type" =>  $request->get('type')
        ];
        if ($files = $request->file('image')) {
           $destinationPath = 'asset/category/'; // upload path
           $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profilefile);
           $update['image'] = $profilefile;
        }

        Category::where('_id', $id)->update($update);
        return response()->success('Category has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->success('Category has been removed successfully');
    }
}
