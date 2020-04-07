<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller  {

	public function index(Request $request) {

		$posts = Post::where('status', 1)
			->where('category', $request->get('category'))
			->select(['_id', 'title', 'image', 'asset_url', 'description'])
			->paginate(1);

		if($posts->count()) {
			return response()->success(__('message'), $posts);
		}
		return response()->fail(__('Oops! There are not post found'));
	}

	 
}