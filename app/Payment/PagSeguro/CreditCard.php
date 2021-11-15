<?php

namespace App\Payment\PagSeguro;

class CreditCard{
    
    private $itens;
    private $user;
    private $cardInfo;
    private $reference;
    private $billing;
    private $billingAddress;
    private $holderCard;
    
    public function __construct($itens, $user, $cardInfo, $reference, $billing, $billingAddress, $holderCard){
        $this->itens = $itens;
        $this->user = $user;
        $this->cardInfo = $cardInfo;
        $this->reference = $reference;
        $this->billing = $billing;
        $this->billingAddress = $billingAddress;
        $this->holderCard = $holderCard;
    }

    public function doPayment(){

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();

         //setar o email do recebedor
        $creditCard->setReceiverEmail(env('PAGSEGURO_EMAIL'));

        //setar referência
        $creditCard->setReference(base64_encode($this->reference));
        $creditCard->setCurrency("BRL");

        //tratamento frete 
        //$this->billing['option'] = 'Frete';
        array_push($this->itens, $this->billing);

        //itens da compra
        foreach($this->itens as $item){
            $creditCard->addItems()->withParameters(
                $this->reference,
                $item['name'],
                $item['amount'],
                $item['price']
            );
        }
    
        $celNumber = substr($this->billingAddress['contact'], 5);
        $celNumber = explode('-', $celNumber);
        $celNumber = implode($celNumber);
        $ddd = stristr(stristr($this->billingAddress['contact'], '('), ')', true);
        $ddd = str_replace('(', '', $ddd);

        $email = env('PAGSEGURO_ENV') == 'sandbox' ? 'test@sandbox.pagseguro.com.br' : $this->user->email;
        $creditCard->setSender()->setName($this->user->name);
        $creditCard->setSender()->setEmail($email);
        $creditCard->setSender()->setPhone()->withParameters(
            $ddd,
            $celNumber
        );
        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            $this->user['cpf']
        );
        $creditCard->setSender()->setHash($this->cardInfo['hash']);
        $creditCard->setSender()->setIp('127.0.0.0');
        $creditCard->setShipping()->setAddress()->withParameters(
            $this->billingAddress['address'],
            $this->billingAddress['number'],
            $this->billingAddress['district'],
            $this->billingAddress['cep'],
            $this->billingAddress['city'],
            $this->billingAddress['state'],
            $this->billingAddress['country'],
            $this->billingAddress['complement']
        );
        $creditCard->setBilling()->setAddress()->withParameters(
            'Rua 4 de Julho',
            '102',
            'Centro',
            '95865000',
            'Paverama',
            'RS',
            'BRA',
            'Apartamento 102'
        );
        $creditCard->setToken($this->cardInfo['card_token']);

        list($quantity, $installmentAmount) = explode('|', $this->cardInfo['installment']);
        $installmentAmount = number_format($installmentAmount, 2, '.', '');

        $creditCard->setInstallment()->withParameters($quantity, $installmentAmount);

        $creditCard->setHolder()->setBirthdate($this->holderCard['birthDate']);
        $creditCard->setHolder()->setName($this->cardInfo['card_name']);
        
        $contactHolder = substr($this->holderCard['contact'], 5);
        $contactHolder = explode('-', $contactHolder);
        $contactHolder = implode($contactHolder);
        $dddHolder = stristr(stristr($this->holderCard['contact'], '('), ')', true);
        $dddHolder = str_replace('(', '', $ddd);

        $creditCard->setHolder()->setPhone()->withParameters(
            $dddHolder,
            $contactHolder
        );

        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            $this->holderCard['cpf']
        );

        
        $creditCard->setMode('DEFAULT');

        $result = $creditCard->register(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        return $result;
    }
}


?>