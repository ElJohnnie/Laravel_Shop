@extends('layouts.checkout')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Finalizar pagamento</h4>
        <div class="site-pagination">
            <a href="{{route('cart.index')}}">Carrinho</a> /
			<a href="{{route('checkout.create.address')}}">Endereços</a> /
			<a href="{{route('checkout.get.shipping')}}">Entrega</a> /
            Pagamento
        </div>
    </div>
</div>
<!-- Page info end -->
<div class="container">
	@include('flash::message')
	<div class="progress mt-5 mb-5">
		<div class="progress-bar bg-info" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
	  </div>
	  <h2>Informações de pagamento</h2>
	<div class="row">
		<div class="col-8">
			<div class="card my-5">
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
										<div class="col-md-4"><label for="">Cpf do titular</label><input type="text" class="form-control" name="cpf_cartao" required></div>
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
						teste 2
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="checkout-cart my-5">
				<h3>Confirme seu carrinho</h3>
				<ul class="product-list">
					@php $total = 0; @endphp
						@foreach(session()->get('cart') as $c)
						<li>
							<div class="pl-thumb"><img src="{{$c['image']}}" alt=""></div>
							<h6>{{$c['name']}}</h6>
							<p>Preço unitário</p>
							<p>R$ {{number_format($c['price'], 2, ',', '.')}}</p>
						</li>
						@php
							$subtotal = $c['price']*$c['amount']; 
							$total += $subtotal;  
							
						@endphp
					@endforeach
				
				</ul>
				<ul class="price-list">
					<li>Total em produtos: R$ {{number_format($total, 2, ',', '.')}}</li>
					<li class="billingTotal"></li>
					<li class="total"></li>
				</ul>
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

<script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
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
	

