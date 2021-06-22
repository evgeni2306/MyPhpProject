<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AddPostController extends Controller
{
    public function AddPost(Request $request)
    {
        if (!Auth::check()) {
            return redirect(route('user.login'));
        } else {
            $validateFields = $request->validate([
                'Text' => 'required',
            ]);
            $validateFields['CreatorId'] = $_SESSION['id'];
            $validateFields['OwnerId'] = $_SESSION['anotherId'];
            $post = Post::create($validateFields);
            if ($post) {
                return redirect()->intended('/id=' . $_SESSION['anotherId']);

            }


        }


    }

    public function AddMyPost(Request $request)
    {
        if (!Auth::check()) {
            return redirect(route('user.login'));
        } else {
            $validateFields = $request->validate([
                'Text' => 'required',
            ]);
            $validateFields['CreatorId'] = $_SESSION['id'];
            $validateFields['OwnerId'] = $_SESSION['id'];
            $post = Post::create($validateFields);
            if ($post) {
                $getPosts = DB::table('posts')
                    ->join('users', 'users.id', '=', 'posts.CreatorId',)
                    ->select('Text', 'name', 'surname')
                    ->where('OwnerId', $_SESSION['id'])->get();

                $_SESSION['Posts'] = $getPosts;
                return redirect()->intended('/private');

            }


        }


    }

}
