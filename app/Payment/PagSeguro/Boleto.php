<?php 

namespace App\Payment\PagSeguro;

class Boleto{

    private $itens;
    private $user;
    private $reference;
    private $senderHash;
    private $billing;
    private $billingAddress;

    public function __construct($itens, $user, $reference, $senderHash, $billing, $billingAddress){
        $this->itens = $itens;
        $this->user = $user;
        $this->reference = $reference;
        $this->senderHash = $senderHash;
        $this->billing = $billing;
        $this->billingAddress = $billingAddress;
    }

    public function doPayment(){

        $boleto = new \PagSeguro\Domains\Requests\DirectPayment\Boleto();

        // Set the Payment Mode for this payment request
        $boleto->setMode('DEFAULT');

        /**
         * @todo Change the receiver Email
         */
        //
        $boleto->setReceiverEmail(env('PAGSEGURO_EMAIL')); 

        // Set the currency
        $boleto->setCurrency("BRL");

        //tratamento frete 
        //$this->billing['option'] = 'Frete';
        array_push($this->itens, $this->billing);


        //itens da compra
        foreach($this->itens as $item){
            $boleto->addItems()->withParameters(
                $this->reference,
                $item['name'],
                $item['amount'],
                $item['price']
            );
        }

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $boleto->setReference($this->reference);

        //set extra amount
        //$boleto->setExtraAmount(11.5);

        $celNumber = substr($this->billingAddress['contact'], 5);
        $celNumber = explode('-', $celNumber);
        $celNumber = implode($celNumber);
        $ddd = stristr(stristr($this->billingAddress['contact'], '('), ')', true);
        $ddd = str_replace('(', '', $ddd);

        // Set your customer information.
        // If you using SANDBOX you must use an email @sandbox.pagseguro.com.br
        $email = env('PAGSEGURO_ENV') == 'sandbox' ? 'test@sandbox.pagseguro.com.br' : $this->user->email;
        $boleto->setSender()->setName($this->user->name);
        $boleto->setSender()->setEmail($email);

        $boleto->setSender()->setPhone()->withParameters(
            $ddd,
            $celNumber
        );

        $boleto->setSender()->setDocument()->withParameters(
            'CPF',
            $this->user['cpf']
        );

        $boleto->setSender()->setHash($this->senderHash);
        $boleto->setSender()->setIp('127.0.0.0');

        // Set shipping information for this payment request
        $boleto->setShipping()->setAddress()->withParameters(
            $this->billingAddress['address'],
            $this->billingAddress['number'],
            $this->billingAddress['district'],
            $this->billingAddress['cep'],
            $this->billingAddress['city'],
            $this->billingAddress['state'],
            'BRA',
        );

        $result = $boleto->register(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        return $result;
    }

}

?>