<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterUserRole extends Controller
{
    public function update(Request $request) 
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'roles' => 'required',
        ]);

        $users = User::where('email', $validatedData['email'])->get();
        if($users->isEmpty()) {
            session()->flash('error', 'User not found.');
        }else{
            foreach ($users as $user) {
                $user->syncRoles($validatedData['roles']);
            }
            session()->flash('success', 'The role has been updated successfully!');
        }
        

        return redirect(RouteServiceProvider::authRedirect());
    }
}
