<?php

namespace App\Http\Controllers\Admin;

use App\Models\{School};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $school = School::select('_id', 'name', 'logo', 'status', 'created_at')->get();
            return datatables()->of($school)
                ->addIndexColumn()
                ->addColumn('action', 'admin.school.action')
                ->editColumn('status', function($status){
                    return '<span class="badge bg-primary">' . $status->status . '</span>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.school.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.school.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $status = School::create([
            "name" => $request->get('name'),
            "logo" => $request->get('logo'), 
            "description" => $request->get('description'),
            "status" => 1,
        ]);
        if($status) {
            return response()->success('School has been added successfully');
        }
        return response()->fail('Oops! Something went wrong');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\School  $School
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        if(!$school) {
            return redirect()->route('admin.school.index');
        }
        return view('admin.school.detail', ['info' => $school]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['info'] = School::where('_id', $id)->first();
        if(!$data['info']) {
            return redirect()->route('admin.school.index');
        }
        return view('admin.school.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $school = School::where('_id', $id)->update([
            "name" => $request->get('name'),
            "logo" => $request->get('logo'), 
            "description" => $request->get('description')
        ]);

        return response()->success('School has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $school->delete();
        return response()->success('School has been removed successfully');
    }
}
