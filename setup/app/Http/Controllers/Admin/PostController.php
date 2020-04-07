<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Post, Category};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $post = Post::select('_id', 'title', 'image', 'type', 'status', 'created_at')->get();
            return datatables()->of($post)
                ->addIndexColumn()
                ->addColumn('action', 'admin.post.action')
                ->editColumn('status', function($status){
                    return '<span class="badge bg-primary">' . $status->status . '</span>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::select('_id', 'title', 'type')->get();
        return view('admin.post.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $status = Post::create([
            "user_id" => auth()->user()->id,
            "title" => $request->get('title'),
            "type" => $request->get('post_type'),
            "age_group" => $request->get('age_group'),
            "asset_url" => $request->get('asset_url'), 
            "image" => $request->get('preview_image'),
            "description" => $request->get('description'),
            "category" => $request->get('category'),
            "status" => 1,
        ]);
        if($status) {
            return response()->success('Post has been added successfully');
        }
        return response()->fail('Oops! Something went wrong');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if(!$post) {
            return redirect()->route('admin.post.index');
        }
        return view('admin.post.detail', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['categories'] = Category::select('_id', 'title', 'type')->get();
        $data['post'] = Post::where('_id', $id)->first();
        if(!$data['post']) {
            return redirect()->route('admin.post.index');
        }
        return view('admin.post.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::where('_id', $id)->update([
            "title" => $request->get('title'),
            "asset_url" => $request->get('asset_url'),
            "image" => $request->get('preview_image'),
            "description" => $request->get('description'),
            "category" => $request->get('category'),
            "age_group" => $request->get('age_group'),
        ]);

        return response()->success('Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->success('Post has been removed successfully');
    }
}
