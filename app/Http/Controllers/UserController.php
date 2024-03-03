<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ログインしていたらユーザーを表示
        return User::find(1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hashedPass = Hash::make($request->user['password']);
        $user = new User;
        $form = $request->all();
        $user->fill($form['user']);
        $user->fill(['password' => $hashedPass])->save();
        $addedUser = User::all()->first();
        return [
            'user' => [
                    'email' => $user->email,
                    'username' => $user->name,
                    'bio' => $addedUser->bio,
                    'image' => $addedUser->img,
                    'token' => $addedUser->token,
                    'password' => $addedUser->password,
            ],
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return User::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $token = $request->bearerToken();
        $currentUser = auth()->user();
        // return ['user' => $currentUser];
        if ($currentUser !== NULL) {
            $user = User::find($currentUser->id);
            $form = $request->user;
            $user->fill($form)->save();
            return [
                'user' => [
                        'email' => $user->email,
                        'username' => $user->name,
                        'bio' => $user->bio,
                        'image' => $user->img,
                        'token' => $token,
                ],
            ];
        }
        return ['msg' => '認証エラーです。'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
