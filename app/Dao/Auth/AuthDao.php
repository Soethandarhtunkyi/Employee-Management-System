<?php

namespace App\Dao\Auth;


use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterRequest;
use App\Contracts\Dao\Auth\AuthDaoInterface;
use App\Models\Employee;
use DB;
use Carbon\Carbon;

/**
 * Data Access Object for Authentication
 */
class AuthDao implements AuthDaoInterface
{
    /**
     * To Save token and email for password reset table
     * @param string email
     * @param string token
     * @return bool
     */
    public function saveToken($email, $token)
    {
        return DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * To get current reset password data of user
     * 
     * @param string $email
     * @param string $token
     * @return Object created reset_password object
     */
    public function getResetPassword($email, $token)
    {
        return DB::table('password_resets')
            ->where([
                'email' => $email,
                'token' => $token
            ])
            ->first();
    }

    /**
     * To change password of user 
     * 
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function resetPassword($email, $password)
    {
        Employee::where('email', $email)
            ->update(['password' => $password]);
        return true;
    }

    /**
     * To delte row of password reset table 
     * 
     * @param string $email
     * @return bool
     */
    public function deletePasswordTableData($email)
    {
        DB::table('password_resets')->where(['email' => $email])->delete();
        return true;
    }
}
