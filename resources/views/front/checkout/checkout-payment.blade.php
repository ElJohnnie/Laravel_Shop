@extends('layouts.checkout')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Finalizar pagamento</h4>
        <div class="site-pagination">
            <a href="{{route('cart.index')}}">Carrinho</a> /
			<a href="{{route('checkout.index')}}">Endereços</a> /
			<a href="{{route('checkout.index.shipping')}}">Entrega</a> /
            Pagamento
        </div>
    </div>
</div>
<!-- Page info end -->
<div class="container">
	@include('flash::message')
	<div class="progress mt-5 mb-5">
		<div class="progress-bar bg-success" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">90%</div>
	  </div>
	  <h2>Informações de pagamento</h2>
	<div class="row">
		<div class="col-md-8" style="margin-top: 5vw; margin-bottom:5vw;">
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-link active" id="nav-cartao-tab" data-toggle="tab" href="#cartao-cred" role="tab" aria-controls="nav-geral" aria-selected="true">Cartão de crédito</a>
					<a class="nav-link" id="nav-boleto-tab" data-toggle="tab" href="#boleto-banc" role="tab" aria-controls="nav-features" aria-selected="false">Boleto</a>
				</div>
			</nav>
			<div class="tab-content">
				<div class="tab-pane fade show active" id="cartao-cred" role="tabpanel" aria-labelledby="cartao-cred">
					<div class="card">
						<div class="card-body">
							<div class="col-lg-12 warning">
								<span class="alert-importante"><i class="fas fa-exclamation-circle"></i></span>
								<strong>IMPORTANTE:</strong> Todos os dados mencionados aqui são referentes ao titular do cartão.			
							</div>
							<form class="processForm mt-3" action="" method="post" data-payment-type="creditcard">
								<div class="row form-row mx-2">
									<div class="form-group col-md-6"><label for="">Nome impresso no cartão</label><input type="text" class="form-control" name="nome_cartao" required></div>
									<div class="form-group col-md-6"><label for="">Número do cartão. <span class="brand"></span></label><input type="text" class="form-control" name="numero_cartao" required><input type="hidden" name="brand_cartao"></div>
								</div>
								<div class="row form-row mx-2">
									<div class="form-group col-md-2"><label for="">Mês de expiração</label><input type="text" class="form-control" name="mes_cartao" required></div>
									<div class="form-group col-md-2"><label for="">Ano de expiração.</label><input type="text" class="form-control" name="ano_cartao" required></div>
									<div class="col-md-2"><label for="">Código de segurança</label><input type="text" class="form-control" name="cvv_cartao" required></div>
								</div>
								<div class="row form-row mx-2">
									<div class="col-md-4"><label for="">CPF do titular</label><input type="text" class="form-control" name="cpf_cartao" required></div>
									<div class="col-md-3"><label for="">Data de nascimento</label><input type="text" class="form-control" name="birth_cartao" required></div>
									<div class="col-md-3"><label for="">Contato do titular</label><input type="text" class="form-control" name="celfone_cartao" required></div>
									<div class="col-md-12 mb-4 installments"></div>
								</div><button type="submit" class="site-btn sb-dark mt-1 my-3">Finalizar pedido</button></form>
							</form>
							<img class="w-100" src="//assets.pagseguro.com.br/ps-integration-assets/banners/seguranca/seguranca_728x90.gif" alt="Banner PagSeguro" title="Parcele suas compras em até 18x">
						</div>
					</div>
				</div>
				<div class="tab-pane fade show" id="boleto-banc" role="tabpanel" aria-labelledby="boleto-banc">
					<div class="card">
						<div  class="card-body">
							<div class="row">
								<div class="col-lg-12 warning">
									<span class="alert-importante"><i class="fas fa-exclamation-circle"></i></span>
									<strong>IMPORTANTE:</strong> Confira os dados antes de pagá-lo.			
								</div>
								<div class="col-lg-12 boleto-banco">
									<i class="fa fa-print" aria-hidden="true"></i>
									<span>Imprima o boleto e <strong> pague no banco</strong> </span>
								</div>
					
								<div class="col-lg-12 boleto-internet">
									<i class="fa fa-laptop" aria-hidden="true"></i>
									<span><strong>ou pague pela internet  </strong> utilizando o código de barras do boleto  </span>
								</div>
					
								<div class="col-lg-12 boleto-validade">
									<i class="far fa-calendar"></i>
									<span> O prazo de validade do boleto é de <b>3 dia(s) útil</b>			</span>
								</div>
							</div>
							<div class="row">
								<div class="col-12 aviso-boleto">
									<strong class="w-100 float-left d-block mt-3"> Importante: </strong>
									<ul class="mb-3">
										<li>Caso o seu computador tenha um programa anti pop-up, será preciso desativá-lo antes de finalizar sua compra e imprimir o boleto ou pagar pelo internet banking;</li>
										<li>Não faça depósito ou transferência entre contas. O boleto não é enviado pelos Correios. Imprima-o e pague-o no banco ou pela internet;</li>
										<li>Se o boleto não for pago até a data de vencimento, o pedido será automaticamente cancelado;</li>
										<li>O prazo de entrega dos pedidos pagos com boleto bancário começa a contar três dias depois do pagamento do boleto, tempo necessário para que a instituição bancária confirme o pagamento.</li>
									</ul>
								</div>
							</div>
							<form class="processForm" action="" method="post" data-payment-type="boleto">
								<div class="card-body"><button class="site-btn sb-dark mt-1 my-3" type="submit">Finalizar pedido</button></div>
							</form>
							<img class="w-100" src="//assets.pagseguro.com.br/ps-integration-assets/banners/seguranca/seguranca_728x90.gif" alt="Banner PagSeguro" title="Parcele suas compras em até 18x">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card" style="margin-top: 5vw; margin-bottom:5vw;">
				<div class="card-header">
					{{ __('Informações do carrinho') }}
				</div>
				<div class="card-body">
					<div class="cart_details">
						<div class="cart_total">
							<ul>
								<li class="d-flex flex-row align-items-center justify-content-start">
									<div class="cart_total_title">Produto</div>
									<div class="cart_total_price ml-auto">Total</div>
								</li>
								@php
									$total = 0;
									$subtotal = 0;
								 	$totalProduct = 0; 
								@endphp
								@foreach(session()->get('cart') as $c)
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_total_title">{{ $c['name'] }} X {{ $c['amount'] }}</div>
										@php $totalProduct = $c['price']*$c['amount'] @endphp
										<div class="cart_total_price ml-auto">R$ {{number_format($totalProduct, 2, ',', '.')}}</div>
									</li>
									@php $subtotal = $totalProduct += $subtotal; @endphp
								@endforeach
								@php
									
									if(session()->has('shipping')){
										$shipping = session()->get('shipping');
										$total = $subtotal + $shipping['price'];
									}  
									
								@endphp
								
								@if(session()->has('shipping'))
								<li class="d-flex flex-row align-items-center justify-content-start">
									<div class="cart_total_title">Frete</div>
									<div class="cart_total_price ml-auto">R$ {{number_format($shipping['price'], 2, ',', '.')}}</div>
								</li>
								<li class="d-flex flex-row align-items-start justify-content-start total_row">
									<div class="cart_total_title">Total</div>
									<div class="cart_total_price ml-auto">R$ {{number_format($total, 2, ',', '.')}}</div>
								</li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div id="preloader-payment">
		<div class="loader-payment"></div>
	</div>
</div>
@php 
$shippingJson = [];
$shippingJson = json_encode($shipping); @endphp
@endsection
@section('scripts')
<script>
	const csrf = '{{ csrf_token() }}';
	var shipping = {!! $shippingJson !!}
	var totalItens = {{ $total }};
</script>
<!-- Scripts PagSeguro -->
@if(env('PAGSEGURO_ENV') == 'sandbox')
	<script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
@else
	<script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
@endif

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
	const sessionId = '{{ session()->get('pagseguro_session_code') }}';
	const urlThanks = '{{ route('checkout.obrigado') }}';
	const urlError = '{{ route('checkout.error') }}';
	const urlProccess = '{{ route('checkout.proccess') }}';
	PagSeguroDirectPayment.setSessionId(sessionId);
</script>
<script src="{{ asset('js/checkout_payment.js') }}"></script>
@endsection
	

