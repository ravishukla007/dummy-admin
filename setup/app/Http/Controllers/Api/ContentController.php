<?php

namespace App\Http\Controllers\Api;

use App\Models\Content;
use Illuminate\Http\Request;


class ContentController {

	public function get(Request $request) {

		$content = Content::where('slug', $request->get('key'))->first();
		if($content) {

			return response()->success(__('message'), [
				'title' => $content->title,
				'content' => $content->content
			]);
		}

		return response()->error(__('message.THE_USER_CREDENTIALS_WERE_INCORRECT'));

		//return $response;
	}

	 
}