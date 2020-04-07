<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Content};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            // Content::create([
            //     "title" => 'Terms of services',
            //     "slug" => "terms-of-services",
            //     "content" => "Terms of services"
            // ]);


            $content = Content::select('_id', 'title', 'slug', 'updated_at');
            return datatables()->of($content->get())
                ->addIndexColumn()
                ->addColumn('action', 'admin.content.action')
                ->make(true);
        }
        return view('admin.content.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['post'] = Content::where('_id', $id)->first();
        if(!$data['post']) {
            return redirect()->route('admin.content.index');
        }
        return view('admin.content.edit', $data);
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
        $content = Content::where('_id', $id)->update([
            "title" => $request->get('title'),
            "content" => $request->get('content')
        ]);

        return response()->success('Content has been updated');
    }

}
