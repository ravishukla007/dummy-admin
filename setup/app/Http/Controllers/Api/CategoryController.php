<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController {

	public function index(Request $request) {

		$this->categories = Category::where('status', 1)->get(['_id', 'title', 'image', 'parent_id']);
		if($this->categories) {

			return response()->success(__('message'), $this->parentCategory($this->categories->toArray()));

			// return response()->success(__('message'), $this->prityCategory(
			// 	$this->parentCategory($this->categories->toArray()))
			// );
		}

		return response()->error(__('message.THE_USER_CREDENTIALS_WERE_INCORRECT'));

		//return $response;
	}

	private function parentCategory($allCategory){
		$parentCategory = $this->filterCategory($allCategory, null);
		$filteredCategory = $this->prityCategory($allCategory, $parentCategory);
		return $filteredCategory;
	}

	private function prityCategory($original, $category){

		return array_map(function($cat) use($original){
			$cat['children'] = $this->prityCategory($original, $this->filterCategory($original, $cat['_id']));
			return $cat;
		}, $category) ;
	}

	private function filterCategory($categories, $id) {

		return array_values(array_filter($categories, function($category) use($id){
			if($category['parent_id'] == $id){
				return true;
			}
			return false;
		}));
	}

	 
}