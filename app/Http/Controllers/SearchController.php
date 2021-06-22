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
            $validateFields = $request->validate([
                'name' => '',
                'surname' => '',
            ]);

            if ($validateFields['name'] != null and $validateFields['surname'] != null) {

                if (User::where('name', $validateFields['name'])->where('surname', $validateFields['surname'])->exists()) {
                    $getUsers = DB::table('users')
                        ->select('name', 'surname', 'city', 'photo', 'id')
                        ->where('name', $validateFields['name'])->where(
                            'surname', $validateFields['surname'])->get();
                    if ($getUsers) {
                        $_SESSION['searchUsers'] = $getUsers;
                        return view('searchResults');
                    }
                }else return view('search');

            }
            if ($validateFields['name'] != null and $validateFields['surname'] == null) {

                if (User::where('name', $validateFields['name'])->exists()) {
                    $getUsers = DB::table('users')
                        ->select('name', 'surname', 'city', 'photo', 'id')
                        ->where('name', $validateFields['name'])
                        ->get();
                    if ($getUsers) {
                        $_SESSION['searchUsers'] = $getUsers;
                        return view('searchResults');
                    }
                }else return view('search');

            }
            if ($validateFields['name'] == null and $validateFields['surname'] != null) {

                if (User::where('surname', $validateFields['surname'])->exists()) {
                    $getUsers = DB::table('users')
                        ->select('name', 'surname', 'city', 'photo', 'id')
                        ->where('surname', $validateFields['surname'])
                        ->get();
                    if ($getUsers) {
                        $_SESSION['searchUsers'] = $getUsers;
                        return view('searchResults');
                    }
                }else return view('search');

            }
            if ($validateFields['name'] == null and $validateFields['surname'] == null) {
                return view('search');
            }


        }


    }
}
