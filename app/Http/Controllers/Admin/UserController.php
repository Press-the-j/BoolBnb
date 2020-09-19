<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function update(Request $request){
      $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:App\User,email,' . Auth::id(),
      ]);
      $data=$request->all();
      $id=Auth::id();
      $user=User::where('id' , $id)->first();
      $dataUpdate=[
        "name"=>$data['name'],
        "surname"=>$data['surname'],
        "email"=>$data['email'],
      ]; 
      $user->update($dataUpdate);

      return redirect()->route('admin.home');
    }
}
