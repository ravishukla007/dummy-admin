<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller {
	/*
		    |--------------------------------------------------------------------------
		    | Password Reset Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller is responsible for handling password reset emails and
		    | includes a trait which assists in sending these notifications from
		    | your application to your users. Feel free to explore this trait.
		    |
	*/

	use SendsPasswordResetEmails;

	/**
	 * Get the response for a successful password reset link.
	 *
	 * @param  string  $response
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function sendResetLinkResponse($response) {
		return response()->success(__('Reset link has been sent to your email box.'));
	}

	/**
	 * Get the response for a failed password reset link.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  string  $response
	 * @throws \Illuminate\Validation\ValidationException
	 */
	protected function sendResetLinkFailedResponse(Request $request, $response) {
		throw ValidationException::withMessages(['email' => trans($response)]);
	}

	/**
	 * Forgot Password via email or mobile number.
	 *
	 * @param \Illuminate\Http\Request  $request
	 */
	public function forgot(Request $request) {

		return $request->has('email') ? $this->sendResetLinkEmail($request) :
		$this->sendOTP($request);
	}

	/**
	 * Send OTP for reset password.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function sendOTP(Request $request) {

		$user = User::where('mobile_number', $request->get('mobile_number'))->first();

		if (!empty($user)) {

			$otp = tap($user)->sendMobileNumberVerificationNotification()->otp;

			if (!empty($request->get('mobile_number'))) {
				$message = "Please use this" . $otp . "for reset password.";
				sendSMS($request->get('mobile_number'), $message, $user->country_code);
			}

			return response()->success(__('message.AN_OTP_IS_SEND_TO_YOUR_MOBILE_NUMBER'), compact('otp'));
		}
		// echo 'new'; die;
		return response()->error(['mobile_number' => __('message.THE_MOBILE_NUMBER_YOU_ENTERED_IS_NOT_ASSOCIATED_TO_ANY_ACCOUNT')]);
	}
}
