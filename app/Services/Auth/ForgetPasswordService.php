<?php

namespace App\Services\Auth;

use App\Contracts\Dao\Auth\AuthDaoInterface;
use App\Contracts\Services\Auth\ForgetPasswordInterface;
use App\Jobs\SendForgetPasswordMailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;

/**
 * Service class for authentication.
 */
class ForgetPasswordService implements ForgetPasswordInterface
{
    /**
     * auth Dao
     */
    private $authDao;

    /**
     * Class Constructor
     * @param AuthDaoInterface
     * @return
     */
    public function __construct(AuthDaoInterface $authDao)
    {
        $this->authDao = $authDao;
    }

    /**
     * To store forget password data and send email
     * @param Request $request request including inputs
     * @return void
     */
    public function processForgetPasswordForm(Request $request)
    {
        $data['token'] = Str::random(64);
        $data['email'] = $request->email;
        // Check password reset datas are successfully stored or not.
        if ($this->authDao->saveToken($data['email'], $data['token'])) {
            dispatch(new SendForgetPasswordMailJob($data));
        }
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
        return $this->authDao->getResetPassword($email, $token);
    }

    /**
     * To change password of user 
     * 
     * @param string $email
     * @param string $password
     * @return Object created reset_password object
     */
    public function resetPassword($email, $password)
    {
        return $this->authDao->resetPassword($email, $password);
    }

    /**
     * To delte row of password reset table 
     * 
     * @param string $email
     * @return Object created reset_password object
     */
    public function deletePasswordTableData($email)
    {
        return $this->authDao->deletePasswordTableData($email);
    }
}
