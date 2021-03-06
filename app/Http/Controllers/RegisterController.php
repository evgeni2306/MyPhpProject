<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function Save(Request $request)
    {
        if (Auth::check())
            return redirect(route('user.private'));

        $validateFields = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $validateFields['city'] = 'Не указан';
        $validateFields['photo'] = 'avatar.jpg';
        $validateFields['type'] = 1;

        if (User::where('email', $validateFields['email'])->exists()) {
            return redirect(route('user.registration'))->withErrors([
                'email' => 'Такой пользователь уже зарегистрирован'
            ]);
        }
        $user = User::create($validateFields);
        if ($user) {
            $_SESSION['name'] = $validateFields['name'];
            $_SESSION['surname'] = $validateFields['surname'];
            $_SESSION['birthday'] = 'Не указан';
            $_SESSION['city'] = 'Не указан';
            $_SESSION['avatar'] = 'avatar.jpg';
            $userr = DB::table('users')->select('id')->where('email', $validateFields['email'])->first();
            $_SESSION['id'] = $userr->id;
            $getPosts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.CreatorId',)
                ->select('Text', 'name', 'surname')
                ->where('OwnerId', $_SESSION['id'])->get();
            $_SESSION['Posts'] = $getPosts;
            $_SESSION['type'] ='1';
            Auth::login($user);
            return redirect(route('user.login'))->withErrors([
                'email' => 'Произошла ошибка при сохранении пользоватея'
            ]);
        }
    }
}
