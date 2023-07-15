<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function edit($id){

        $user = User::findOrFail($id);
        $this->authorize($user);
        // die($user);
        return view('student.account.edit', ['user'=>$user]);
    }

    public function update(Request $request, $id){
        $user = User::with('student')->findOrFail($id);
        $this->authorize($user);

        $email = $request->validate([
            'email' => "bail|required|min:3|email|unique:users,email," . $user->id,
        ]);

        if (!empty( $request->post('password') )) {

            $password = $request->validate([
                'password' => "confirmed|min:6",
            ]);
            $password = Hash::make($password['password']);
            
            $user->password = $password;
        }

        $user->email = $email['email'];

        $user->save();

        return redirect()->route('user.account.edit', ['user'=>Auth()->user()->id])->with('success', 'Account successfully updated');
    }
}
