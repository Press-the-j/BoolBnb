<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class HomeController extends Controller
{
  public function index()
  {
  
  $user=User::where('id', Auth::id())->first();
  $messageArr=getMessage();
  $allMessages=$messageArr[0];
  $unreadMessages=$messageArr[1];
  $data=[
    'allMessages'=>$allMessages,
    'unreadMessages'=>$unreadMessages,
    'user'=>$user
  ];
  
  
  return view('admin.home', $data);
  }
}
