<?php

namespace App\Http\Controllers\Auth;

use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Contracts\Services\Auth\ForgetPasswordInterface;
use App\Http\Requests\ForgetPasswordRequest;
use Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Auth Interface
     */
    private $forgetPasswordInterface;

    /**
     * Create a new controller instance.
     * @param AuthServiceInterface $authServiceInterface
     * @return void
     */
    public function __construct(ForgetPasswordInterface $forgetPasswordInterface)
    {
        $this->forgetPasswordInterface = $forgetPasswordInterface;
    }
    /**
     * To show forgoet password email form page
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    /**
     * To Store password reset data in database and sned user email.
     *
     * @param \App\Http\Requests\ForgetPasswordRequest $request
     * @return response()
     */
    public function submitForgetPasswordForm(ForgetPasswordRequest $request)
    {
        $this->forgetPasswordInterface->processForgetPasswordForm($request);

        // Check there is any error with mail sending.
        if (Mail::failures()) {
            return back()->withErrors('Something went wrong. Please try again!');
        }
        return back()->withSuccess('We have e-mailed your password reset link!');
    }

    /**
     * To show reset password form page
     *
     * @return response()
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    /**
     * To reset the password with user input data
     *
     * @param App\Http\Requests\PasswordResetRequest $request
     * @return response()
     */
    public function submitResetPasswordForm(PasswordResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);
        
        $passwordResetInstance = $this->forgetPasswordInterface->getResetPassword($email, $token);
        // Check password reset table with current email and token.
        if (!$passwordResetInstance) {
            return back()->withInput()->withErrors('Invalid token!');
        }

        // Check reset password process successfully.
        if ($this->forgetPasswordInterface->resetPassword($email, $password) &&
            $this->forgetPasswordInterface->deletePasswordTableData($email)) {
            return redirect("login")->withSuccess('Your password has been changed!');
        }
    }
}
