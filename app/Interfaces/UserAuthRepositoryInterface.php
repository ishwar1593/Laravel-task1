<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserAuthRepositoryInterface
{
    public function signup(Request $req);
    public function login(Request $req);
    public function logout(Request $req);
}
