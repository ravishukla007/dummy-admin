<?php

namespace App\Http\Controllers\Api;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolController extends Controller  {

	public function index(Request $request) {

		$schools = School::where('status', 1)
			->select(['_id', 'name', 'logo'])
			->get();

		if($schools->count()) {
			return response()->success(__('message'), $schools);
		}
		return response()->fail(__('Oops! There are no any school found'));
	}

	 
}