<?php

namespace App\Contracts\Services\Auth;

use Illuminate\Http\Request;

/**
 * Interface for passwrod reset service.
 */
interface ForgetPasswordInterface
{
    /**
     * To store forget password data and send email
     * 
     * @param Request $request request including inputs
     * @return void
     */
    public function processForgetPasswordForm(Request $request);

    /**
     * To get current reset password data of user
     * 
     * @param string $email
     * @param string $token
     * @return Object created reset_password object
     */
    public function getResetPassword($email, $token);

    /**
     * To change password of user 
     * 
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function resetPassword($email, $password);

    /**
     * To deelte row of password reset table 
     * 
     * @param string $email
     * @return bool
     */
    public function deletePasswordTableData($email);
}
