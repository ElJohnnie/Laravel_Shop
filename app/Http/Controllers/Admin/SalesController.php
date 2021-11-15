<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserOrder;
use App\User;
//Facades para disparo de mail
use Illuminate\Support\Facades\Mail;
//importar classe mailer que vai ser usado aqui
use App\Mail\UserShippingCodeEmail;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = UserOrder::orderBy('id', 'DESC')->paginate(25);
        return view('admin.sales.index', compact('sales'));
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function codigoEnvio(Request $request, $id){
        try{
            $data = $request->all();
            $sale = UserOrder::findOrFail($id);
            Mail::to($sale->user->email)->send(new UserShippingCodeEmail($sale->user, $data['codigo']));
            $sale->codigo_envio = $data['codigo'];
            $sale->status_envio = true;
            $sale->update();
            //metodo para disparo de email
            flash('Código de rastreio enviado para '. $sale->user->name . ' com sucesso.')->success();
            return redirect()->route('admin.sales.index');
        }catch(\Exception $e){

        }
    }

    public function alterPagseguroStatus(Request $request){
        try{
            $data = $request->all();
            $sale = UserOrder::findOrFail($data['id']);
            $sale->update([
                'pagseguro_status' => $data['value']
            ]);
            $data = [
                'codigo' => $sale->pagseguro_code
            ];
            if($sale->pagseguro_code >= 4){
                $ordersItems = unserialize($sale->itens);
                dd($ordernsItems);
            }
            return response()->json([
                'data' => $data,
            ]);
        }catch(\Exception $e){
            $data = [
                'mensagem' => 'Houve um erro indentificável, tente novamente mais tarde.'
            ];
            return response()->json([
                'data' => $data,
            ]);
        }
    }
}
