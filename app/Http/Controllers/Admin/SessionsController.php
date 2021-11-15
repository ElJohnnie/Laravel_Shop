<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Rainwater\Active\Active;

class SessionsController extends Controller
{
    public function index()
    {
        $users = Active::users()->get();
        return view('admin.sessions.index', compact('users'));

    }
}
