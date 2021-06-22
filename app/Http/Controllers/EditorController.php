<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditorController extends Controller
{
    public function Update(Request $request)
    {
        if (!Auth::check()) {
            return redirect(route('user.pageEditor'));
        } else {


            $getType = DB::table('users')->select('type')
                ->where('id', $_SESSION['id'])->first();
            $_SESSION['type'] = $getType->type;
            if ($_SESSION['type'] != '2') {
                $validateFields = $request->validate([
                    'name' => 'required',
                    'surname' => 'required',
                    'city' => 'required',
                    'birthday' => 'required',
                    'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $imageName = time() . '.' . $request->photo->extension();
                $validateFields['photo'] = $imageName;
                $request->photo->move(public_path('images'), $imageName);
                $_SESSION['name'] = $validateFields['name'];
                $_SESSION['surname'] = $validateFields['surname'];
                $_SESSION['birthday'] = $validateFields['birthday'];
                $_SESSION['city'] = $validateFields['city'];
                $_SESSION['avatar'] = $imageName;
                $user = User::where('id', $_SESSION['id'])->update($validateFields);
                return redirect(route('user.private'));

            } else return redirect(route('user.private'));

        }


    }
}
