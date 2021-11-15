@extends('layouts.checkout')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Finalizar pagamento</h4>
        <div class="site-pagination">
            <a href="{{route('cart.index')}}">Carrinho</a> /
			<a href="{{route('checkout.index')}}">Endereços</a> /
            Entrega
        </div>
    </div>
</div>
<!-- Page info end -->
<div class="container">
	@include('flash::message')
	<div class="progress mt-5 mb-5">
		<div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
	  </div>
	  <h2>Selecione a forma de entrega</h2>
	<div class="row">
		<div class="col-md-8">
			<form action="{{ route('checkout.set.shipping') }}" method="post">
				@csrf
				<div class="card" style="margin-top: 5vw">
					<div class="card-header">
						{{ __('Formas de entrega') }}
					</div>
					<div class="card-body shipping-place">
						
					</div>
				</div>

				<div class="card" style="margin-bottom: 5vw;">
					<div class="card-body">
						<button type="submit" class="site-btn sb-dark mt-1">Selecionar frete</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-4">
			<div class="card" style="margin-top: 5vw;">
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
@php $selected_address = $s_address['cep']; @endphp
@endsection
@section('scripts')
<script>
	const addressUrl = '{{ route('checkout.get.shipping') }}';
</script>
<script src="{{ asset('js/checkout_shipping.js') }}"></script>
@endsection
	

