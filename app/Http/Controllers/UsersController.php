<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Users\UpdateProfileRequest;


class UsersController extends Controller
{
    public function index(){
        return view('users.index')->with('users', User::all());
    }
    public function makeAdmin(User $user){
        $user->role = 'admin';
        $user->save();

        return redirect(route('users.index'))
        ->with('success', 'User made admin successfully');
    }
    public function makeWriter(User $user){
        if($user->id == 1){
            return redirect(route('users.index'))
            ->with('error', "You can't change the role of the big boss!!");
        }

        $user->role = 'writer';
        $user->save();

        return redirect(route('users.index'))
        ->with('success', 'User made writer successfully');
    }
    
    public function editProfile(){
        return view('users.edit')->with('user', auth()->user());
    }
    public function updateProfile(UpdateProfileRequest $request){
        
        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'about' => $request->about
        ]);

        return redirect()->back()->with('success', 'Profile Update Successfully');
    }
}
