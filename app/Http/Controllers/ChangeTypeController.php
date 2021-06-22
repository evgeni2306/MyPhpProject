<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChangeTypeController extends Controller
{
    public function UpdateType()
    {
        if (!Auth::check()) {
            return redirect(route('user.login'));
        } else {
            if ($_SESSION['type'] == '0') {
                if ($_SESSION['anotherType'] == '2') {
                    $validateFields['type'] = '1';
                } else if ($_SESSION['anotherType'] == '1') {
                    $validateFields['type'] = '2';
                }

                $user = User::where('id', $_SESSION['anotherId'])->update($validateFields);
                return redirect()->intended('/id=' . $_SESSION['anotherId']);

            } else return redirect(route('user.private'));

        }


    }
}
