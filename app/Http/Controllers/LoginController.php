<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function Login(Request $request)
    {
        if (Auth::check())
            return redirect()->intended(route('user.private'));

        $formFields = $request->only(['email', 'password']);

        if (Auth::attempt($formFields)) {
            $user = DB::table('users')->where('email', $formFields['email'])->first();
            if ($user->type != '2') {
                $_SESSION['name'] = $user->name;
                $_SESSION['surname'] = $user->surname;
                $_SESSION['city'] = $user->city;
                $_SESSION['birthday'] = $user->birthday;
                $_SESSION['id'] = $user->id;
                $_SESSION['avatar'] = $user->photo;
                $_SESSION['type'] = $user->type;

                $getPosts = DB::table('posts')
                    ->join('users', 'users.id', '=', 'posts.CreatorId',)
                    ->select('Text', 'name', 'surname')
                    ->where('OwnerId', $_SESSION['id'])->get();

                $_SESSION['Posts'] = $getPosts;


            } else {
                $_SESSION['id'] = $user->id;
                $_SESSION['type'] = '2';
                return redirect()->intended(route('user.private'));
            }

        }
        return redirect(route('user.login'))->withErrors([
            'email' => 'Неверное имя пользователя или пароль'
        ]);
    }
}
