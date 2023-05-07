<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(){
        $admin = User::where('type', 1)->get()->first();   
        return view('admin.profile.edit', ['admin'=>$admin]);
    }

    public function update(UpdateAdmin $request, $id){

        $validatedData = $request->validated();

        $admin = User::findOrFail($id);
        
        if (!empty($validatedData['password'])) {

            $password = $request->validate([
                'password' => "min:6",
            ]);
            $password = Hash::make($password['password']);
            
            $admin->password = $password;
            $admin->save();   
        }

        return redirect()->route('admin.profile.edit')->with('success', 'Admin successfully updated');
    }
}
