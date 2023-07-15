<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    
    public function edit($id){

        $user = User::with('student')->findOrFail($id);
        $this->authorize($user);
        // die($user);
        return view('student.profile.edit', ['user'=>$user]);
    }

    public function update(UpdateUser $request, $id){
        $validatedData = $request->validated();
        $user = User::with('student')->findOrFail($id);

        // $email = $request->validate([
        //     'email' => "bail|required|min:3|email|unique:users,email," . $user->id,
        // ]);

        $this->authorize($user);
        // if (!empty($validatedData['password'])) {

        //     $password = $request->validate([
        //         'password' => "min:6",
        //     ]);
        //     $password = Hash::make($password['password']);
            
        //     $user->password = $password;
        // }

        $user->name = $validatedData['name'];
        // $user->email = $email['email'];

        $user->save();

        $user->student->address = $validatedData['address'];

        //AVATAR
        if($request->hasFile('avatar')){
            $img_path = $request->file('avatar')->store('avatars');
            
            if( isset($user->student->img_path) ){
                Storage::delete($user->student->img_path);
                $user->student->img_path = $img_path;
            }else{
                $user->student->img_path = $img_path;
            }
        }

        $user->student->save();

        return redirect()->route('user.profile.edit', ['user'=>Auth()->user()->id])->with('success', 'Profile successfully edit');
    }

    public function registerGetYear(Request $request){
        $course =  $request->get('course');
        if($course == 'BSECE'){
            return 5;
        }else{
            return 4;
        }
    }


    

}
