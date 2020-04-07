<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller {



	/**
     * update loggedin user profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $update = [
            "name" => $request->get('name'),
            "age_group" => $request->get('age_group'),
            "school" => $request->get('school'),
        ];

        if ($files = $request->file('avatar')) {
           $destinationPath = 'asset/profile/'; // upload path
           $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profilefile);
           $update['avatar'] = $profilefile;
           if($avatar = auth()->user()->getOriginal('avatar')) {
           	if(file_exists("asset/profile/$avatar")) {
           		unlink("asset/profile/$avatar");
           	}
           }
        }

        $status = User::where('_id', auth()->user()->_id)->update($update);
        if($status) {
            return response()->success('Profile has been updated successfully', 
            		$this->getUserData(auth()->user()->_id));
        }
        return response()->fail('Oops! Something went wrong');

    }

    public function getUserData($user_id) {
  		$where = array('users.id' => $user_id);

  		$field = array('_id', 'name', 'email', 'mobile_number', 'avatar', 'status', 'age_group');

  		$user = User::select($field)->where('_id', $user_id)->first();

  		return $user;
	}

	/**
	 * Change User password
	 *
	 * @param  Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function changePassword(Request $request) {
      if (!\Hash::check($request->get('current_password'), auth()->user()->password)) {
         return response()->fail('Please enter correct old password');
      }

      User::where('_id', auth()->user()->_id)->update([
            "password" => bcrypt($request->get('password'))
      ]);
      return response()->success('Password has been changed successfully');

	}
}