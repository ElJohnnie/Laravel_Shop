@extends('layouts.single')
@section('content')
	<!-- Page info -->
	<div class="page-top-info">
		<div class="container">
			<h4>Seu Carrinho</h4>
			<div class="site-pagination">
				<a href="{{route('home')}}">Home</a> /
				Carrinho / Checkout Whatsapp
			</div>
		</div>
	</div>
	<!-- Page info end -->
	<!-- checkout section  -->
	<section class="checkout-section spad">
		<div class="container">
			<div class="row justify-content-center">	
				<div class="col-lg-8 ">
					<div class="checkout-cart">
						<h3>Confirme seu carrinho</h3>
						<ul class="product-list">
							@php $total = 0; @endphp
                            @foreach($cartItems as $c)						
								<li>
									<div class="pl-thumb"><img src="{{$c['image']}}" alt=""></div>
									<h6>{{$c['name']}}</h6>
									<p>{{$c['price']}}</p>
								</li>
								@php
									$subtotal = $c['price']*$c['amount']; 
									$total += $subtotal;  	
								@endphp
                            @endforeach
							@php $endTotal = $total + 5; @endphp
						</ul>
						<ul class="price-list">
							<li>Total<span>R${{number_format($total, 2, ',', '.')}}</span></li>
							<li>Entrega<span>R$5,00</span></li>
							<li class="total">Total<span>R${{number_format($endTotal, 2, ',', '.')}}</span></li>
						</ul>
						<script></script>
						<div class="row justify-content-center">
							<div class="col">
								<a href="{{route('checkout.whats.finish')}}" class="site-btn sb-green">Aceitar</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- checkout section end -->
	@endsection
