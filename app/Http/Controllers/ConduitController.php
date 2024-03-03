<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ConduitController extends Controller
{
    public function register(Request $request)
    {
        // $this->validate($request, User::$rules);
        return ['msg' => 'success'];
    }
}
