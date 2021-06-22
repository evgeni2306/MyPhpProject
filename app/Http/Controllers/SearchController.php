<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function Search(Request $request)
    {

        if (!Auth::check()) {
            return redirect(route('user.login'));
        } else {
            $getType = DB::table('users')->select('type')
                ->where('id', $_SESSION['id'])->first();
            $_SESSION['type'] = $getType->type;


            if ($_SESSION['type'] != 2) {
                $validateFields = $request->validate([
                    'name' => '',
                    'surname' => '',
                ]);

                if ($validateFields['name'] != null and $validateFields['surname'] != null) {

                    if (User::where('name', $validateFields['name'])->where('surname', $validateFields['surname'])->exists()) {
                        $getUsers = DB::table('users')
                            ->select('name', 'surname', 'city', 'photo', 'id')
                            ->where('name', $validateFields['name'])
                            ->where('surname', $validateFields['surname'])
                            ->where('type', '!=', '0')->get();
                        if ($getUsers) {
                            $_SESSION['searchUsers'] = $getUsers;
                            return view('searchResults');
                        }
                    } else return view('search');

                }
                if ($validateFields['name'] != null and $validateFields['surname'] == null) {

                    if (User::where('name', $validateFields['name'])->exists()) {
                        $getUsers = DB::table('users')
                            ->select('name', 'surname', 'city', 'photo', 'id')
                            ->where('name', $validateFields['name'])
                            ->where('type', '!=', '0')
                            ->get();
                        if ($getUsers) {
                            $_SESSION['searchUsers'] = $getUsers;
                            return view('searchResults');
                        }
                    } else return view('search');

                }
                if ($validateFields['name'] == null and $validateFields['surname'] != null) {

                    if (User::where('surname', $validateFields['surname'])->exists()) {
                        $getUsers = DB::table('users')
                            ->select('name', 'surname', 'city', 'photo', 'id')
                            ->where('surname', $validateFields['surname'])
                            ->where('type', '!=', '0')
                            ->get();
                        if ($getUsers) {
                            $_SESSION['searchUsers'] = $getUsers;
                            return view('searchResults');
                        }
                    } else return view('search');

                }
                if ($validateFields['name'] == null and $validateFields['surname'] == null) {
                    return view('search');
                }

            } else {
                return redirect(route('user.private'));
            }
        }


    }
}
