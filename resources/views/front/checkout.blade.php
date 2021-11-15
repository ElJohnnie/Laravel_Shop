@extends('layouts.single')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Checkout</h4>
        <div class="site-pagination">
            <a href="{{route('home')}}">Home</a> / <a href="{{route('cart.index')}}">Carrinho</a>
            / Finalizar compra
        </div>
    </div>
</div>
<!-- Page info end -->
<!-- checkout section  -->
<section class="checkout-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 order-2 order-lg-1">
				<div class="checkout-form">
					<div class="cf-title">Selecione o endereço de entrega</div>
					<div class="row">	
						<div class="col-md-7">
							<p>Informações de endereço</p>
						</div>
						<div class="col-md-5">
							<div class="form-check">
								<input class="form-check-input" type="radio" name="address" id="yAddress" value="yAddress">
								<label class="form-check-label" for="yAddress">
								  Endereço cadastrado
								</label>
							  </div>
							  <div class="form-check">
								<input class="form-check-input" type="radio" name="address" id="nAddress" value="nAddress">
								<label class="form-check-label" for="nAddress">
								  Endereço diferente
								</label>
							</div>
						</div>
					</div>
					<form class="billing-form was-validated ">
						<div class="row address-inputs">
							
						</div>
					</form>
					<div class="cf-title">Selecione a forma de entrega</div>
					<div class="row shipping-btns">
						
					</div>
					<div class="cf-title">Selecione a forma de pagamento</div>
					<div class="accordion payment_place" id="accordionExample">
						
					</div>					
				</div>
			</div>
			<div class="col-lg-4 order-1 order-lg-2">
				<div class="checkout-cart">
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
</section>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div id="preloader-payment">
		<div class="loader-payment"></div>
	</div>
  </div>
<!-- checkout section end -->
@endsection
@section('scripts')
<!-- Scripts fretes -->
<script>
	const csrf = '{{ csrf_token() }}';
	var userInformations = {!!  $userJson  !!};
	var totalItens = {{ $total }};
	const urlFrete = '{{ route("checkout.correios") }}';
	const urlAddFrete = '{{ route("checkout.setfretes") }}';
</script>
<script src="{{ asset('js/checkout.js') }}"></script>
<!-- Fim Scripts Correios -->
<!-- Scripts PagSeguro -->
<script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<!--<script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>-->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
	const sessionId = '{{ session()->get('pagseguro_session_code') }}';
	const urlThanks = '{{ route('checkout.obrigado') }}';
	const urlError = '{{ route('checkout.error') }}';
	const urlProccess = '{{ route('checkout.proccess') }}';
	PagSeguroDirectPayment.setSessionId(sessionId);
</script>
@endsection
	

