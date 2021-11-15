<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user = $this->user->findOrFail($user);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $user = $this->user->findOrFail($user);
        return view('front.edituser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function update(UsersRequest $request, $user)
    {
        try{
            $data = $request->all();
            $users = $this->user->findOrFail($user);

            $users->update([
                'name' => $data['name'],
                'cpf' => $data['cpf'],
                'cep' => $data['cep'],
                'phone' => $data['phone'],
                'celfone' => $data['celfone'],
                'email' => $data['email']
            ]);
            flash('Seu cadastro foi editado com sucesso')->success();
            return redirect()->route('cliente');
        }catch(\Exception $e){
            $message = 'Não foi possível editar seu cadastro.'; 
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }

    public function updateAddress(Request $request, $user)
    {
        try{
            $data = $request->all();
            $users = $this->user->findOrFail($user);

            $users->update([
                'cep' => $data['cep'],
                'address' => $data['address'],
                'complement' => $data['complement'],
                'number' => $data['number'],
                'district' => $data['district'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
            ]);
            flash('Seu endereço foi editado com sucesso')->success();
            return redirect()->route('cliente');
        }catch(\Exception $e){
            $message = 'Não foi possível editar seu cadastro.'; 
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //section costumer
    public function costumer()
    {
        $user = Auth::user();
        return view('front.user', compact('user'));
    }

    
}
