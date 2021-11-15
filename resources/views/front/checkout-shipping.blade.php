@extends('layouts.checkout')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Finalizar pagamento</h4>
        <div class="site-pagination">
            <a href="{{route('cart.index')}}">Carrinho</a> /
			<a href="{{route('checkout.create.address')}}">Endereços</a> /
            Entrega
        </div>
    </div>
</div>
<!-- Page info end -->
<div class="container">
	@include('flash::message')
	<div class="progress mt-5 mb-5">
		<div class="progress-bar bg-info" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">50%</div>
	  </div>
	  <h2>Selecione a forma de entrega</h2>
	<div class="row">
		<div class="col-8">
			<form action="{{ route('checkout.set.shipping') }}" method="post">
				@csrf
				<div class="card my-5" >
					<div class="card-header">
						{{ __('Formas de entrega') }}
					</div>
					<div class="card-body shipping-place">
						
					</div>
				</div>

				<div class="card mb-5">
					<div class="card-body">
						<button type="submit" class="site-btn sb-dark mt-1">Usar entrega selecionada</button>
					</div>
				</div>
			</form>
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
@php $selected_address = $address['cep']; @endphp
@endsection
@section('scripts')
<script>
	const addressUrl = '{{ route('checkout.get.shipping') }}';
</script>
<script src="{{ asset('js/checkout_shipping.js') }}"></script>
@endsection
	

