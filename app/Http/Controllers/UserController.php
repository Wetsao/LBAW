<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{
    public function showProfile(){
        if (Auth::check()) {
            $user = Auth::user();
            if($user->is_admin){
                return view('pages.profile', ['user' => $user]);
            }
            else if(!($user->is_admin)){
                return view('pages.profile',['user' => $user]);
            }
        }
        $this->authorize('view', $user);
        return view('pages.homepage');
    }

    public function showEditUserPage()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if($user->is_admin){
                return view('pages.edit-profile', ['user' => $user]);
            }
            else if(!($user->is_admin)){
                return view('pages.edit-profile', ['user' => $user]);
            }
        }
    }

    public function userpageUpdate(Request $request){
        if (Auth::check()) {
            $user = Auth::user();

            $user->name = $request['name'];
            $user->email = $request['email'];
            //$this->authorize('update', $user);
            $user->save();
            return view('pages.profile',['user' => $user]);

        }
    }

    public function showAllUsers()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $allusers = User::all();

            if($user->is_admin)
                return view('pages.homepage', ['allusers' => $allusers]);
        }
    }

    public function removeAccount($id) {
        $user = User::find($id);
        $this->authorize('delete', $user);
        $user->delete();
        return redirect('/login')->with('status','Project Deleted with successfully!');
    }

}