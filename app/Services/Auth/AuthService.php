<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRegisterRequest;
use App\Contracts\Dao\Auth\AuthDaoInterface;
use App\Contracts\Services\Auth\AuthServiceInterface;

/**
 * Service class for authentication.
 */
class AuthService implements AuthServiceInterface
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
     * To Login the user
     * 
     * @param array $user input value
     * @param bool $remember me or not
     * @return bool loggedin or not
     */
    public function login($user, $remember)
    {
        // Log in the user with credentials
        return Auth::attempt($user, $remember);
    }
}
