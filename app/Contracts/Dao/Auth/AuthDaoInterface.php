<?php

namespace App\Contracts\Dao\Auth;

use App\Http\Requests\UserRegisterRequest;

/**
 * Interface of Data Access Object for Authentication
 */
interface AuthDaoInterface
{
    /**
     * To Save token and email for password reset table
     * @param string email
     * @param string token
     * @return bool
     */
    public function saveToken($email, $token);

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
     * To delte row of password reset table 
     * 
     * @param string $email
     * @return bool
     */
    public function deletePasswordTableData($email);
}
