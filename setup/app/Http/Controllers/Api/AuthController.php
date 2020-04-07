<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Resources\UserChangeEmailResource;
use App\Http\Resources\UserChangeMobileNumberResource;
use App\Http\Resources\UserResource;
use App\Models\DeviceInfo;
use App\Models\Setting;
use App\Models\UserChangeEmail;
use App\Models\UserChangeMobileNumber;
use App\Models\UserTranslation;use Config;use Illuminate\Auth\Events\Registered;use Illuminate\Http\Request;use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Auth;

/**
 * Control the applications authetication.
 *
 * @author  Dharmendra Solanki
 */
class AuthController {


	public function baseUrl(Request $request) {
		
		return response()->success(__('baseurl'), [
			'api_url' => url('api'),
			'image_path' => asset('public'),
			'age_group' => [
				"3-to-5" => "3 to 5",
				"6-to-7" => "6 to 7",
				"8-to-13" => "8 to 13",
			]
		]);
	}

	public function sendOtp(Request $request) {

		$user = User::where('mobile_number', $request->get('username'))->first();
		if($user) {
			$user->otp = rand(1000, 9999);
			$user->save();
			return response()->success(__('OTP has been sent to your register mobile number'),[
				"otp" => $user->otp
			]);	
		}
		return response()->fail(__('You are not register with us'));
	}

	public function verifyAndLogin(Request $request) {

		$user = User::where('mobile_number', $request->get('username'))->first();
		if($user) {
			// dd($request->get('otp'));
			if($user->otp != $request->get('otp')) {
				return response()->fail(__('You have entered invalid otp'));
			}
			$user->otp = null;
			$user->save();
			return response()->success(__('You have loggedin'),[
				'token' => $user->createToken('kidsapp'),
				'user' => new UserResource($this->getUserData($user->_id))
			]);	
		}
		return response()->fail(__('You are not register with us'));
	}
	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\JsonResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(Request $request) {
		$data = $this->validateLogin($request);

		return $response = $this->issueAccessToken($request);

		if ($response->isOk()) {

			dd('dddd');
			$username = $this->username();
			$language_id = $data['language_id'];
			$where = array($username => $request->input($username));

			$user = $this->getUserData();

			//$user = User::where($username, $request->input($username))->first();
			if ($user->deleted_at != '') {
				return response()->error(__('message.YOUR_ACCOUNT_HAS_BEEN_DELETED_PLZ_CONTACT_TO_ADMIN'));
			}

			if ($user->status == 'Inactive') {
				return response()->error(__('message.YOUR_ACCOUNT_IS_INACTIVE_PLZ_CONTACT_TO_ADMIN'));
			}

			if (!empty($user)) {
				$current_role = ($user->role == 0) ? (1) : (($user->role == 1) ? (1) : (2));
				User::where('id', $user->id)->update(array('current_role' => $current_role));
			}

			$this->deviceInfo($user, $data);

			return response()->success(__('message.LOGIN_SUCCESSFULLY'), [
				'token' => $this->getToken($response),
				'user' => new UserResource($user),
			]);
		}

		return response()->error(__('message.THE_USER_CREDENTIALS_WERE_INCORRECT'));

		//return $response;
	}

	public function getUserData($user_id) {
		$where = array('users.id' => $user_id);

		$field = array('_id', 'name', 'email', 'mobile_number', 'avatar', 'status', 'otp');

		$user = User::select($field)->where('_id', $user_id)->first();

		return $user;
	}

	/**
	 * Get token information from the Oauth response.
	 *
	 * @param  Response $response
	 * @return object
	 */
	public function getToken(Response $response) {
		return json_decode($response->getContent());
	}

	/**
	 * Validate the user login request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 */
	protected function validateLogin(Request $request) {
		  
		$username = $this->username();
		$rule = $this->usernameValidationRules();

		$request->request->add([$username => $request['username']]);

		$data = $request->validate([
			$username => $rule,
			'password' => 'required|string|min:6|max:30',
			'notification_id' => 'required|string|max:500',
			'device_type' => 'required|string|max:100|in:android,iphone,web'
		]);

		$request->request->add([
			'client_id' => '5e766064a5e2ee43be2296c4', 
			'client_secret' => '9rfAaDYttnSnIm2A3JtgUoFjSOkxLoFBldtNklpB'
		]);

		return $data;
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username() {

		$username = request('username');
		$field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

		return $field;

		//return request('email') ? 'email' : 'mobile_number';
	}
	/**
	 * Validation rules for username.
	 *
	 * @param string
	 */
	public function usernameValidationRules() {
		return $this->username() == 'email' ? 'required|string|email' : 'required|digits:10';
	}

	/**
	 * Issue access token for user.
	 *
	 * @param  User   $user
	 * @param  array  $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function issueAccessToken(Request $request) {

		// $d = Auth::guard()->attempt([
		// 	"email" => $request->input($this->username()),
		// 	"password" => $request->input('password')
		// ]);

		// // Fire off the internal request
		$request->request->add([
			'grant_type' => 'password',
			'username' => $request->input($this->username()),
			'password' => $request->input('password'),
			'scope' => '*',
		]);
		return \Route::dispatch(Request::create('oauth/token', 'POST'));
	}

	public function register(Request $request) {
	 	
		// $checkMobile = $this->checkMobileAccountDeletedOrNot($request->get('mobile_number'));
		// if ($checkMobile) {
		// 	return response()->error(__('message.YOUR_ACCOUNT_HAS_BEEN_DELETED_PLZ_CONTACT_TO_ADMIN'));
		// }

		// $checkEmail = $this->checkEmailAccountDeletedOrNot($request->get('email'));
		// if ($checkEmail) {
		// 	return response()->error(__('message.YOUR_ACCOUNT_HAS_BEEN_DELETED_PLZ_CONTACT_TO_ADMIN'));
		// }


		// Validate the request
		$data = $request->validate([
			'mobile_number' => $this->checkMobileValidation(), 
			'email' => $this->checkEmailValidation(), 
			// 'password' => 'required|string|min:6|max:30',
			'name' => 'required|string|max:255',
			'notification_id' => 'required|string|max:500',
			'device_type' => 'required|string|max:100|in:android,iphone,web'
		]);

		// $request->request->add([
		// 	'client_id' => $request->get('client_id'), 
		// 	'client_secret' => $request->get('client_secret')
		// ]);

		// $request->request->add([
		// 	'client_id' => '5e766064a5e2ee43be2296c4', 
		// 	'client_secret' => '9rfAaDYttnSnIm2A3JtgUoFjSOkxLoFBldtNklpB'
		// ]);

		// Create new user
		$user_id = $this->create($data);

		$user = $this->getUserData($user_id);

		// $this->deviceInfo($user, $data);

		// if (!empty($request->get('mobile_number'))) {
		// 	$message = "hi " . $data['first_name'] . ", Registration successfully, Please use this " . $data['otp'] . " for mobile verification.";
		// 	sendSMS($request->get('mobile_number'), $message, $request->get('country_code'));

		// }

		// $dataCustomer = array(
		// 	'subject' => 'Login Credential',
		// 	'filename' => 'emails.user-registration',
		// 	'email' => $request->get('email'),
		// 	'otp' => $data['otp'],
		// 	'mobile_number' => $request->get('mobile_number'),
		// 	'name' => $request->get('first_name') . ' ' . $request->get('last_name'),
		// 	'password' => $request->get('password'),
		// );

		// mailSendForCustomer($dataCustomer);

		 

		// Emit the registration event
		// event(new Registered($user));

		// Send success response
		return response()->success(__('message.reg_success') . " Your otp: {$user->otp}", [
			'token' => $user->createToken('kidsapp'),
			'user' => new UserResource($user),
		]);
	}

	public function checkMobileAccountDeletedOrNot($mobile_number) {
		$info = User::where('mobile_number', $mobile_number)->first();

		if (!empty($info)) {
			if ($info->deleted_at != '') {

				return true;
			}
		}
		return false;

	}

	public function checkEmailAccountDeletedOrNot($email) {
		$info = User::where('email', $email)->first();

		if (!empty($info)) {
			if ($info->deleted_at != '') {

				return true;
			}
		}
		return false;

	}

	public function checkMobileValidation() {
		if (request('role') == 2) {

			/*if (request('email') == '' && request('mobile_number') == '') {
					return 'required|digits:10|unique:users';
				} else {
					return '';
			*/
			if (request('mobile_number') != '') {
				return 'required|digits:10|unique:users';
			} else {
				return '';
			}

		} else {
			return 'required|digits:10|unique:users';
		}

	}

	public function checkImageValidation() {
		if (request('role') == 2) {
			return 'nullable|image|max:10240';

		} else {
			return 'required|image|max:10240';
		}

	}

	public function checkEmailValidation() {
		if (request('role') == 2) {

			/*if (request('email') == '' && request('mobile_number') == '') {
					return 'required|email|unique:users';
				}

			*/

			if (request('email') != '') {
				return 'required|email|unique:users';
			} else {
				return '';
			}
		} else {

			return 'required|email|unique:users';

		}

	}

	public function deviceInfo(User $user, array $data) {
		$deviceInfo = [
			'device_name' => $data['device_name'],
			'imei' => $data['imei'],
			'notification_id' => $data['notification_id'],
			'apns_id' => $data['apns_id'],
			'device_type' => $data['device_type'],
			'modal_no' => $data['modal_no'],
			'user_agent' => $data['user_agent'],
			'os_version' => $data['os_version'],
			'is_active' => 1,
			'last_activity_time' => date('Y-m-d H:i:s'),

		];

		$device_info = $user->deviceInfo()->select(['id'])
			->where('imei', $data['imei'])
			->first();

		DeviceInfo::where('notification_id', $data['notification_id'])->update(array('is_current' => 0));

		$user->deviceInfo()->update(array('is_current' => 0));
		if (!empty($device_info)) {
			$deviceInfo['is_current'] = 1;
			return $user->deviceInfo()->where('id', $device_info->id)->update($deviceInfo);

		} else {

			$deviceInfo['is_current'] = 1;
			$deviceInfo['created_at'] = date('Y-m-d H:i:s');
			return $user->deviceInfo()->create($deviceInfo);

		}
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data) {
		$createArray = [
			'name' => $data['name'],
			'mobile_number' => $data['mobile_number'],
			'status' => 1,
			'email' => $data['email'],
			// 'password' => bcrypt($data['password']),
			"otp" => rand(1000, 9999),
			'created_at' => date('Y-m-d H:i:s'),
		];

		return User::insertGetId($createArray);
	}

	public function resetPassword(Request $request) {

		$res['success'] = false;
		$res['message'] = "You have entered wrong otp. Please enter valid otp.";
		$res['code'] = 400;

		$data = $request->validate([
			'otp' => 'required',
			'new_password' => 'required|string|min:6|max:30',
			'confirm_password' => 'required|string|same:new_password|min:6|max:30',

		]);

		$user = User::where('otp', $request->get('otp'))->first();

		if ($user) {

			$password = bcrypt($request->get('new_password'));

			$userInfo = User::where('id', $user->id)->update(array('password' => $password));

			$res['success'] = true;
			$res['message'] = "Password successfully updated. Please login with new password";
			$res['code'] = 200;

		}

		return response()->json($res);

	}

	public function changeMobile(Request $request) {
		if (!empty($request->header('accept-language'))) {
			$language_type = $request->header('accept-language');
			$language_id = getLanguageByType($language_type);
		}

		$user = $request->user();
		$request->validate([
			'mobile_number' => 'required|unique:users,mobile_number,' . $user->id,
		]);

		$otp = rand(1000, 9999);

		$user->otp = $otp;
		$user->mobile_number_verified_at = null;
		$user->mobile_number = $request->get('mobile_number');
		$user->save();

		if (!empty($request->get('mobile_number'))) {
			$message = "Your otp is " . $otp . " for verification.";
			sendSMS($request->get('mobile_number'), $message, $user->country_code);
		}
		//$userMobile = UserChangeMobileNumber::where('user_id', $user->id)->first();

		//$userInfo = $user->changeMobile()->updateOrCreate([],$dataArray);
		return response()->success(__('A fresh OTP is send to your mobile number.'));
	}

	public function changeMobileNew(Request $request) {
		if (!empty($request->header('accept-language'))) {
			$language_type = $request->header('accept-language');
			$language_id = getLanguageByType($language_type);
		}

		$user = $request->user();
		$request->validate([
			'mobile_number' => 'required|unique:users,mobile_number,' . $user->id,
		]);

		$otp = rand(1000, 9999);

		$dataArray = array(
			'mobile_number' => $request->get('mobile_number'),
			'country_id' => $request->get('coutry_id'),
			'country_code' => $request->get('country_code'),
			'otp' => $otp,
			'user_id' => $user->id,
			'status' => 0,
			'created_at' => date('Y-m-d H:i:s'),
		);

		if (!empty($user->mobile_number)) {
			$message = "Your otp is " . $otp . " for verification.";
			sendSMS($user->mobile_number, $message, $user->country_code);
		}
		//$userMobile = UserChangeMobileNumber::where('user_id', $user->id)->first();

		$userInfo = $user->changeMobile()->updateOrCreate([], $dataArray);

		return response()->success(__('A fresh OTP is send to your mobile number.'),
			new UserChangeMobileNumberResource($userInfo));
	}

	public function updateMobileNumber(Request $request) {
		if (!empty($request->header('accept-language'))) {
			$language_type = $request->header('accept-language');
			$language_id = getLanguageByType($language_type);
		}

		$user = $request->user();
		$request->validate([
			'user_mobile_id' => 'required',
			'otp' => 'required',
		]);

		$where = array('user_id' => $user->id, 'id' => $request->get('user_mobile_id'), 'otp' => $request->get('otp'));
		$userMobile = UserChangeMobileNumber::where($where)->first();

		if (!empty($userMobile)) {
			UserChangeMobileNumber::where('id', $userMobile->id)->update(array('otp' => NULL, 'status' => 1));

			$updateData = array(
				'mobile_number' => $userMobile->mobile_number,
				'country_id' => $userMobile->country_id,
				'country_code' => $userMobile->country_code,
				'mobile_number_verified_at' => date('Y-m-d H:i:s'),
				'otp' => null,
			);
			$user->update($updateData);

			$user = $this->getUserData($user->id, $language_id);

			if ($user) {
				return response()->success(__('Mobile Successfully Verified.'),
					new UserResource($user)
				);
			} else {
				return response()->error(__('Your mobile not verified'));
			}

		} else {
			return response()->error(__('You are entered correct otp'));

		}

	}

	public function changeEmail(Request $request) {
		$language_id = $this->default_language_id;
		if (!empty($request->header('accept-language'))) {
			$language_type = $request->header('accept-language');
			$language_id = getLanguageByType($language_type);
		}

		$user = $request->user();
		$request->validate([
			'email' => 'required|unique:users,email,' . $user->id,
		]);

		$otp = rand(1000, 9999);

		$dataArray = array(
			'email' => $request->get('email'),
			'otp' => $otp,
			'user_id' => $user->id,
			'status' => 0,
			'created_at' => date('Y-m-d H:i:s'),
		);

		$userInfo = $user->changeEmail()->updateOrCreate([], $dataArray);

		if (!empty($userInfo)) {
			$getUserData = getUserData($user->id, $language_id);
			$userName = '';
			if (!empty($getUserData)) {
				$userName = $getUserData->first_name . ' ' . $getUserData->last_name;
			}

			$dataCustomer = array(
				'subject' => 'Change Email',
				'filename' => 'emails.change-email-for-user',
				'email' => $request->get('email'),
				'name' => $userName,
				'code' => $otp,
			);

			mailSendForCustomer($dataCustomer);
			return response()->success(__('A fresh OTP is send to your email address.'),
				new UserChangeEmailResource($userInfo));
		} else {

			return response()->error(__('you are not send mail and not generate otp'));
		}

	}

	public function updateEmail(Request $request) {
		$language_id = $this->default_language_id;
		if (!empty($request->header('accept-language'))) {
			$language_type = $request->header('accept-language');
			$language_id = getLanguageByType($language_type);
		}

		$user = $request->user();
		$request->validate([
			'user_email_id' => 'required',
			'otp' => 'required',
		]);

		$where = array('user_id' => $user->id, 'id' => $request->get('user_email_id'), 'otp' => $request->get('otp'));

		$userEmail = UserChangeEmail::where($where)->first();

		if (!empty($userEmail)) {
			UserChangeEmail::where('id', $userEmail->id)->update(array('otp' => NULL, 'status' => 1));

			$user->update(array('email' => $userEmail->email));

			$user = $this->getUserData($user->id, $language_id);

			if ($user) {
				return response()->success(__('Email Successfully Verified.'),
					new UserResource($user)
				);
			} else {
				return response()->error(__('Your email not verified'));
			}

		} else {

			return response()->error(__('You are entered correct otp'));

		}

	}

	/**
	 * Logout user from the app.
	 *
	 * @param  Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout(Request $request) {
		$accessToken = $request->user()->token()->delete();
		return response()->success(__('Logged out'));
	}
}