<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LgpdController extends Controller
{
    public function setOk(Request $request){
        $data = $request->all();
        session()->put('lgpd-ok', $data['concordo']);
        return redirect()->back();
    }
}
