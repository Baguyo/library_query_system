<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit($id){
        $admin = User::findOrFail($id);   
        $this->authorize($admin);
        return view('admin.profile.edit', ['admin'=>$admin]);
    }

    public function update(UpdateAdmin $request, $id){

        $validatedData = $request->validated();

        $admin = User::findOrFail($id);
        $this->authorize($admin);
        
        if (!empty($validatedData['password'])) {

            $password = $request->validate([
                'password' => "min:6",
            ]);
            $password = Hash::make($password['password']);
            
            $admin->password = $password;
            $admin->save();   
        }

        return redirect()->route('admin.profile.edit', ['admin'=>Auth()->user()->id])->with('success', 'Admin successfully updated');
    }

    public function create(){
        return view('admin.profile.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'bail|required|min:3',
            'email' => 'bail|required|min:3|email|unique:users',
            'password'=> 'bail|required|confirmed|min:6',
        ]);

        $password = Hash::make($validatedData['password']);

        $new_admin = new User();
        $new_admin->name = $validatedData['name'];
        $new_admin->email = $validatedData['email'];
        $new_admin->type = 1;
        $new_admin->password = $password;

        $new_admin->save();

        return redirect()->route('admin.add.create')->with('success', 'New Admin successfully added');
        


    }

    
}
