<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Payment\PagSeguro\CreditCard;
use App\Payment\PagSeguro\Boleto;
use App\Payment\PagSeguro\Notification;
use Auth;
use App\User;
use App\Product;
use App\AddressUser;
use App\Correios\Fretes;
use App\Billing;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index()
    { //session()->forget('pagseguro_session_code');
        if(!auth()->check()){
            return redirect()->route('login');
        }
        //dd(session()->get('cart'));
        if(!session()->get('cart')){
            return redirect()->route('cart.index');
        }
        $total = 0;
        $itensCarrinho = array_map(function($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));
        $itensCarrinho = array_sum($itensCarrinho);
        $user = auth()->user();
        $user = User::findOrFail($user->id);
        $this->pagSeguroSession();
        return view('front.checkout.checkout-address', compact('itensCarrinho', 'user')); 
    }
    


    public function createAddress(Request $request){
        try{
            $data = $request->all();
            $address = AddressUser::create($data);
            $user = auth()->user();
            $address->address()->sync($user);
            flash('Endereço cadastrado com sucesso')->success();
            return redirect()->route('checkout.index');
        }catch(\Exception $e){
            if(env('APP_DEBUG')) {
                $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar!';
                }
                flash($message)->warning();
                return redirect()->back()->withInput();
        }
    }

    public function updateAddress(Request $request, $id){
        try{
            $data = $request->all();
            $address = AddressUser::findOrFail($id);
            $address->update($data);
            flash('Endereço alterado com sucesso')->success();
            return redirect()->route('checkout.index');
        }catch(\Exception $e){
            if(env('APP_DEBUG')) {
                $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar!';
                }
                flash($message)->warning();
                return redirect()->back()->withInput();
        }
    }

    public function deleteAddress(Request $request){
        try{
            $data = $request->all();
            $address = AddressUser::findOrFail($data['id']);
            $user = auth()->user();
            $address->address()->detach($user);
            $address->delete();
            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Deletado com sucesso'
                ]
            ]); 
        }catch(\Exception $e){
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao deletar!';
            return response()->json([
                    'data' => [
                    'status' => false,
                    'message' => $message
                ]
                ], 401);
        }
    }

    public function setAddress(Request $request){
        try{
            $cartItems = array_map(function($line){
                return $line['amount'] * $line['price'];
            }, session()->get('cart'));
            $cartItems = array_sum($cartItems);
            $data = $request->all();
            $user = auth()->user();
            $address = AddressUser::findOrFail($data['address_id']);

            $new_address = [
                'id' => $address->id,
                'name' => $address->name,
                'lname' => $address->lname,
                'contact' => $address->contact,
                'cep' => $address->cep,
                'address' => $address->address,
                'number' => $address->number,
                'district' => $address->district,
                'complement' => $address->complement,
                'city' => $address->city,
                'state' => $address->state,
                'country' => $address->country,
            ];
            if($user->address->contains($address)){
                if(session()->has('address')){
                    session()->forget('address');
                    session()->put('address', $new_address);
                    return redirect()->route('checkout.index.shipping.address');
                }else{
                    session()->put('address', $new_address);
                    return redirect()->route('checkout.index.shipping.address');
                }
            }else{
                flash('Não foi possível prosseguir o pagamento, tente novamente mais tarde.')->warning();
                return redirect()->back()->withInput();
            }
        }catch(\Exception $e){
            $message = 'Não foi possível setar o endereço o produto!'; 
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }

    public function indexShippingAddress()
    { //session()->forget('pagseguro_session_code');
        if(!auth()->check()){
            return redirect()->route('login');
        }
        //dd(session()->get('cart'));
        if(!session()->get('cart')){
            return redirect()->route('cart.index');
        }
        $total = 0;
        $itensCarrinho = array_map(function($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));
        $itensCarrinho = array_sum($itensCarrinho);
        $user = auth()->user();
        $user = User::findOrFail($user->id);
        $this->pagSeguroSession();
        return view('front.checkout.checkout-address-shipping', compact('itensCarrinho', 'user')); 
    }

    public function setShippingAddress(Request $request){
        try{
            $cartItems = array_map(function($line){
                return $line['amount'] * $line['price'];
            }, session()->get('cart'));
            $cartItems = array_sum($cartItems);
            $data = $request->all();
            $user = auth()->user();
            $address = AddressUser::findOrFail($data['address_id']);

            $s_address = [
                'id' => $address->id,
                'name' => $address->name,
                'lname' => $address->lname,
                'contact' => $address->contact,
                'cep' => $address->cep,
                'address' => $address->address,
                'number' => $address->number,
                'district' => $address->district,
                'complement' => $address->complement,
                'city' => $address->city,
                'state' => $address->state,
                'country' => $address->country,
            ];
            if($user->address->contains($address)){
                if(session()->has('s_address')){
                    session()->forget('s_address');
                    session()->put('s_address', $s_address);
                    return redirect()->route('checkout.index.shipping');
                }else{
                    session()->put('s_address', $s_address);
                    return redirect()->route('checkout.index.shipping');
                }
            }else{
                flash('Não foi possível prosseguir o pagamento, tente novamente mais tarde.')->warning();
                return redirect()->back()->withInput();
            }
        }catch(\Exception $e){
            $message = 'Não foi possível setar o endereço o produto!'; 
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }


    public function indexShipping()
    { //session()->forget('pagseguro_session_code');
        if(!auth()->check()){
            return redirect()->route('login');
        }
        //dd(session()->get('cart'));
        if(!session()->get('cart')){
            return redirect()->route('cart.index');
        }
        $total = 0;
        $cartItems = array_map(function($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));
        $cartItems = array_sum($cartItems);
        $user = auth()->user();
        $user = User::findOrFail($user->id);
        $s_address = session()->get('s_address');
        $this->pagSeguroSession();
        return view('front.checkout.checkout-shipping', compact('cartItems', 'user', 's_address')); 
    }

    public function getShippings(){
        $address = session()->get('s_address');
        for($i = 0; $i <= 1; $i++){
            $correios[$i] = new Fretes;
            $service[0] = '04014';
            $service[1] = '04510';
            //com valores simulados, alterar isso depois
            $correios[$i]->calcFrete($address['cep'], '0.500', '20', '7', '16', 'n', $service[$i], '40');
        }
        $data = [
            'sedex' => $correios[0],
            'PAC' => $correios[1],
            'status' => true
        ];
        return response()->json([
            'data' => $data,
        ]);
    }

    public function setShipping(Request $request){
        try{
            $data = $request->all();
            $shipping['name'] = 'Frete';
            $shipping['price'] = $data['shipping'];
            $shipping['amount'] = 1;
            $shipping['slug'] = 'frete';
            if(session()->has('cart') && session()->has('address')){
                if(session()->has('shipping')){
                    session()->forget('shipping');
                    session()->put('shipping', $shipping);
                    return redirect()->route('checkout.index.payment');
                }else{
                    session()->put('shipping', $shipping);
                    return redirect()->route('checkout.index.payment');
                }
            }
        }catch(\Exception $e){
            $message = 'Não foi possível setar o endereço!'; 
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }

    public function indexPayment(){
        //session()->forget('pagseguro_session_code');
        if(!auth()->check()){
            return redirect()->route('login');
        }
        //dd(session()->get('cart'));
        if(!session()->get('cart')){
            return redirect()->route('cart.index');
        }
        $total = 0;
        $address = session()->get('address');
        $cartItems = array_map(function($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));
        $cartItems = array_sum($cartItems);
        $user = auth()->user();
        $user = User::findOrFail($user->id);
        $shipping = session()->get('shipping');
        $this->pagSeguroSession();
        return view('front.checkout.checkout-payment', compact('cartItems', 'user', 'shipping')); 
    }

    public function whatsapp()
    {
            if(!auth()->check()){
                return redirect()->route('login');
            }
            //dd(session()->get('cart'));
            if(!session()->get('cart')){
                return redirect()->route('cart.index');
            }
            $cartItems = session()->get('cart');
            return view('front.checkout-whatsapp', compact('cartItems'));
    }

    public function whatsappFinish()
    {
        //processmessage
        $cartItems = session()->get('cart');
        $items = array();
        $items = array_column($cartItems, 'name');       
        $itemsMessage = implode(', ', $items);
        $user = auth()->user();
        $message = "Dia ".date("d.m.y")." Olá, me chamo ". $user->name." resido em ".$user->city."/".$user->state.". Desejo comprar os seguintes itens: *".$itemsMessage."*";
        return Redirect::to("https://api.whatsapp.com/send?phone=5551996792646&text={$message}");
    }

    public function proccess(Request $request)
    {
        try{
            $dataPost = $request->all();
            $billing = session()->get('shipping');
            $billingAddress = session()->get('address');
            $shippingAddress = session()->get('s_address');
            if($dataPost['paymentType'] == 'creditcard'){
                $holderCard = [
                    'birthDate' => $dataPost['birthDate'],
                    'cpf' => $dataPost['cpfCartao'],
                    'contact' => $dataPost['celfone'],
                    'name' => $dataPost['card_name']
                ];
            }
            $cartItems = session()->get('cart');
            $user = auth()->user();
            $reference = Str::random(40);
            $payment = $dataPost['paymentType'] == 'boleto'
                ? new Boleto($cartItems, $user, $reference, $dataPost['hash'], $billing, $billingAddress)
                : new CreditCard($cartItems, $user, $dataPost, $reference, $billing, $billingAddress, $holderCard);
            $result = $payment->doPayment();
            if(count($cartItems) > 1){
                for($i=0; $i < count($cartItems); $i++){
                    $values[$i] = ($cartItems[$i]['price'] * $cartItems[$i]['amount']);
                    $itensValue = array_sum($values);
                    $value = ($itensValue + $billing['price']);
                    $strValue = strval($value);
                }
            }else{
                $values[1] = ($cartItems[0]['price'] * $cartItems[0]['amount']);
                $values[2] = $billing['price'];
                $value = array_sum($values);
                $strValue = strval($value);
            }
            $userOrder = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'itens' => serialize($cartItems),
                'user_id' => $user->id,
                'type' => $dataPost['paymentType'],
                'link_boleto' => null,
                'value' => $strValue,
                'billing_address' => serialize($shippingAddress),
                'data_compra' => Carbon::now()->format('d/m/y'),
                'status_envio' => 0
            ];
            foreach($cartItems as $c){
                $this->discountAmount($c['id'], $c['amount']);
                $this->sumSales($c['id'], $c['amount']);
            }
            session()->forget('cart');
            session()->forget('pagseguro_session_code');
            $dataJson = [
                'status' => true,
                'message' => 'Pedido criado com sucesso!',
                'order' => $reference
            ];
            if($dataPost['paymentType'] == 'boleto'){
                $dataJson['link_boleto'] = $result->getPaymentLink();
                $userOrder['link_boleto'] = $result->getPaymentLink();;
            }
            $user->orders()->create($userOrder);
            return response()->json([
                'data' => $dataJson
            ]); 
        }catch(\Exception $e){
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar!';
            return response()->json([
                    'data' => [
                    'status' => false,
                    'message' => $message
                ]
                ], 401);
        }
        
    }

    

    public function fretes(Request $request){
        
        try{
            $dataPost = $request->all();
            for($i = 0; $i <= 1; $i++){
                $correios[$i] = new Fretes;
                $service[0] = '04014';
                $service[1] = '04510';
                $correios[$i]->calcFrete($dataPost['cep'], $dataPost['wheight'], $dataPost['length'], $dataPost['height'], $dataPost['widtht'], $dataPost['mainHand'], $service[$i], $dataPost['diameter']);
            }
            $data = [
                'sedex' => $correios[0],
                'PAC' => $correios[1],
                'status' => true
            ];
            return response()->json([
                'data' => $data,
            ]);
        }catch(\Exception $e){
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar frete!';
            return response()->json([
                    'data' => [
                    'status' => false,
                    'message' => $message
                ]
                ], 401);
        }
        
    }

    public function telaObrigado()
    {
        $products = Product::orderBy('id', 'DESC')->take(10)->get();
        return view('front.obrigado', compact('products'));
    }


    public function error()
    {
        return view('front.error');
    }

    public function notification()
    {
        $notification = new Notification();
        $notification = $notification->getTransaction();
        dd($notification);
    }

    private function pagSeguroSession()
    {
        if(!session()->has('pagseguro_session_code'))
        {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            session()->put('pagseguro_session_code',  $sessionCode->getResult());
        }

    }

    public function jsonEncode($user){
        $data = ["Address" => $user->address, "Number" => $user->number,  "District" => $user->district, "City" => $user->city, "CEP" => $user->cep, "State" => $user->state, "Country" => $user->country, "Complement" => $user->complement, "Celfone" => $user->celfone];
        $res = json_encode($data);
        return $res;
    }

    public function discountAmount($product, $amount){
        $queryProduct = Product::findOrFail($product); 
        $queryProduct->amount = $queryProduct->amount - $amount;
        $queryProduct->save();
    }

    public function sumSales($product, $amount){
        $queryProduct = Product::findOrFail($product); 
        $queryProduct->sales = $queryProduct->sales + $amount;
        $queryProduct->save();
    }

}
