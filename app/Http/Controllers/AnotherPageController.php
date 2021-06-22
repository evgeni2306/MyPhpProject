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
        if ((is_numeric($id)) and ($id > 1)) {
            $request = DB::table('users')->select('name', 'surname', 'city', 'birthday', 'photo', 'type')
                ->where('id', $id)->first();
            if (Auth::check() and $_SESSION['type'] == '0') {
                $this->SaveInformation($request, $id);
                if ($_SESSION['anotherId'] == $_SESSION['id']) {
                    return redirect()->intended(route('user.private'));
                } else {
                    return view('anotherPageReview');
                }
            }
            if ($request->type != '0' and $request->type != '2') {
                $this->SaveInformation($request, $id);
                if (Auth::check()) {
                    if ($_SESSION['anotherId'] == $_SESSION['id']) {
                        return redirect()->intended(route('user.private'));
                    } else {
                        return view('anotherPage');
                    }
                } else return view('anotherPage');
            } else {
                if ($request->type == '0') {
                    return redirect(route('user.private'));
                }
                if ($request->type == '2') {
                    return view('anotherPageBanned');

                }

            }


        } else {

            if (!Auth::check()) {
                return redirect(route('user.login'));
            } else {
                return redirect(route('user.private'));
            }
        }


    }

    public function SaveInformation($request, $id)
    {
        $_SESSION['anotherName'] = $request->name;
        $_SESSION['anotherSurname'] = $request->surname;
        $_SESSION['anotherCity'] = $request->city;
        $_SESSION['anotherBirthday'] = $request->birthday;
        $_SESSION['anotherAvatar'] = $request->photo;
        $_SESSION['anotherId'] = $id;
        $_SESSION['anotherType'] = $request->type;

        $getPosts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.CreatorId',)
            ->select('Text', 'name', 'surname')
            ->where('OwnerId', $_SESSION['anotherId'])->get();

        $_SESSION['anotherPosts'] = $getPosts;
    }
}
