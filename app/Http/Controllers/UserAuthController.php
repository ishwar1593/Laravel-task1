<?php

namespace App\Http\Controllers;

use App\Interfaces\UserAuthRepositoryInterface;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    protected $userAuthRepository;


    public function __construct(UserAuthRepositoryInterface $userAuthRepository)
    {
        $this->userAuthRepository = $userAuthRepository;
    }

    public function signup(Request $req)
    {
        return $this->userAuthRepository->signup($req);
    }

    public function login(Request $req)
    {
        return $this->userAuthRepository->login($req);
    }

    public function logout(Request $req)
    {
        return $this->userAuthRepository->logout($req);
    }
}
