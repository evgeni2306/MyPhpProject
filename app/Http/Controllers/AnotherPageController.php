<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnotherPageController extends Controller
{
    public function GetAnotherPage($id)
    {
        $id = (int)$id;
        if ((is_numeric($id)) and ($id > 0)) {
            $request = DB::table('users')->select('name', 'surname', 'city', 'birthday', 'photo',)->where('id', $id)->first();
            $_SESSION['anotherName'] = $request->name;
            $_SESSION['anotherSurname'] = $request->surname;
            $_SESSION['anotherCity'] = $request->city;
            $_SESSION['anotherBirthday'] = $request->birthday;
            $_SESSION['anotherAvatar'] = $request->photo;
            $_SESSION['anotherId'] = $id;


            $getPosts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.CreatorId',)
                ->select('Text', 'name', 'surname')
                ->where('OwnerId', $_SESSION['anotherId'])->get();

            $_SESSION['anotherPosts'] = $getPosts;
            if (Auth::check()) {
                if ($_SESSION['anotherId'] == $_SESSION['id']) {
                    return redirect()->intended(route('user.private'));
                } else {
                    return view('anotherPage');
                }
            } else return view('anotherPage');
        } else {
            if (!Auth::check())
                return redirect(route('user.login'));
            else {
                return redirect(route('user.private'));
            }
        }


    }
}
