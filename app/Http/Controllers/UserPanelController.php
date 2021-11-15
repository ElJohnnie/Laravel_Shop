<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;

class UserPanelController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function index(){
        $user = Auth::user();
        return view('front.user', compact('user'));
    }

    public function address(){
        $user = Auth::user();
        return view('front.clientpanel.address', compact('user'));
    }

    public function orders(){
        $user = Auth::user();
        $orders = $user->orders()->orderBy('id','DESC')->get();
        return view('front.clientpanel.orders', compact('user', 'orders'));
    }

    public function favorites(){
        $user = Auth::user();
        $favorites = $user->favorites()->orderBy('id','DESC')->get();
        return view('front.clientpanel.favorites', compact('user', 'favorites'));
    }

    public function dataShow($id){
        $user = $this->user->findOrFail($id);
        return view('front.clientpanel.dataedit', compact('user'));
    }

    public function addressShow($id){
        $user = $this->user->findOrFail($id);
        return view('front.clientpanel.addressedit', compact('user'));
    }



}
