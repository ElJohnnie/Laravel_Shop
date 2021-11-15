@extends('layouts.products')
@section('content')
	<!-- Page info -->
	<div class="page-top-info">
		<div class="container">
			<h4>{{$product->name}}</h4>
			<div class="site-pagination">
				<a href="{{route('home')}}">Home</a> /
				@foreach($product->categories as $c)
				<a href="{{ route('categorias', ['category' => $c->slug]) }}">{{$c->name}}</a> / {{$product->name}}
				@endforeach
			</div>
		</div>
	</div>
	<!-- Page info end -->
	<!-- product section -->
	<section class="product-section">
		<div class="container">
			<div class="back-link">
				<a href="{{ route('categorias', ['category' => $c->slug]) }}"> &lt;&lt; Voltar para @foreach($product->categories as $c){{$c->name}}@endforeach</a>
			</div>
			@include('flash::message')
			<div class="row">
				<div class="col-lg-6">
					<div class="product-pic-zoom">
						<img class="product-big-img" src="{{asset('storage/' . $product->images->first()->image)}}" alt="">
					</div>
					<div class="product-thumbs" tabindex="1" style="overflow: hidden; outline: none;">
						<div class="product-thumbs-track">
							@for ($i = 0; $i < count($product->images); $i++)
									<div class="pt active" data-imgbigurl="{{asset('storage/' . $product->images[$i]->image)}}"><img class="" src="{{asset('storage/' . $product->images[$i]->image)}}" alt=""></div>
							@endfor
						</div>
					</div>
				</div>
				<div class="col-lg-6 product-details">
					<h2 class="p-title">{{$product->name}}</h2>
					<h3 class="p-price">R$ {{number_format($product->price, 2, ',', '.')}}</h3>
					<!-- Adicionar um middleware no request do envio ao carrinho para retornar -->
					<h4 class="p-stock">@if($product->amount == 0)<span>Esgotado</span>@endif @if($product->amount > 0)<span>Em estoque</span>@endif</h4>
					@php if(session('notAmount')){
							$errorProduct = session()->get('errorProduct');
						}
					@endphp
					@if(session()->get('notAmount'))
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
							A quantidade solicitada para {{$product->name}} não está disponível.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endif
					@if(session()->get('zeroAmount'))
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
							A quantidade solicitada para {{$product->name}} foi de zero.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endif
					<!-- Form da compra -->
					<form action="{{ route('cart.add') }}" method="POST">
						@csrf
						<input type="hidden" name="product[id]" value="{{$product->id}}">
						<input type="hidden" name="product[name]" value="{{$product->name}}">
						<input type="hidden" name="product[price]" value="{{$product->price}}">
						<input type="hidden" name="product[image]" value="{{asset('storage/' . $product->images->first()->image)}}">
						<input type="hidden" name="product[slug]" value="{{$product->slug}}">
                        <div class="size">
                            <p>Tamanho</p>
                            @if($product->options->count() > 0)
                                <select name="product[option]" class="form-control form-control-lg mt-3 mb-3 w-25">
                                    @foreach($product->options as $op)
                                        <option value="{{ $product->id }}-{{ $op->name }}">{{ $op->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
						<div class="quantity">
							<p>Comprar quantos</p>
							<div class="pro-qty">
								<input name="product[amount]" type="number" value="1">
							</div>
						</div>
						<button class="site-btn @if($product->amount <= 0) disabled @endif " @if($product->amount <= 0) disabled @endif aria-disabled="true">ADICIONAR AO SEU CARRINHO</button>
					</form>
					<!-- Fim Form -->
					<div id="accordion" class="accordion-area">
						<div class="panel">
							<div class="panel-header" id="headingOne">
								<button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">Descrição</button>
							</div>
							<div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="panel-body">
									{{$product->body}}
								</div>
							</div>
						</div>
						<!--
						<div class="panel">
							<div class="panel-header" id="headingTwo">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">care details </button>
							</div>
							<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
								<div class="panel-body">
									<img src="./img/cards.png" alt="">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingThree">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">shipping & Returns</button>
							</div>
							<div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
								<div class="panel-body">
									<h4>7 Days Returns</h4>
									<p>Cash on Delivery Available<br>Home Delivery <span>3 - 4 days</span></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
								</div>
							</div>
						</div>
						-->
					</div>
					<!--
					<div class="social-sharing">
						<a href=""><i class="fa fa-google-plus"></i></a>
						<a href=""><i class="fa fa-pinterest"></i></a>
						<a href=""><i class="fa fa-facebook"></i></a>
						<a href=""><i class="fa fa-twitter"></i></a>
						<a href=""><i class="fa fa-youtube"></i></a>
					</div>
					-->
				</div>
			</div>
		</div>
	</section>
	<!-- product section end -->


	<!-- RELATED PRODUCTS section -->
	<section class="related-product-section">
		<div class="container">
			<div class="section-title">
				<h2>ADICIONADOS RECENTEMENTE</h2>
			</div>
			<div class="product-slider owl-carousel">
				@foreach($products as $p)
				<div class="product-item" id="{{ $p->id }}-{{ $p->name }}">

					<div class="pi-pic">
						<a href="{{route('produto.single', ['slug' => $p->slug ])}}">
							<img class="card-img-fit" src="{{asset('storage/' . $p->images->first()->image)}}" alt="">
						</a>
						<form action="{{ route('cart.add') }}" method="post">
							<div class="pi-links">

									@csrf
									<input type="hidden" name="product[id]" value="{{$p->id}}">
									<input type="hidden" name="product[name]" value="{{$p->name}}">
									<input type="hidden" name="product[price]" value="{{$p->price}}">
									<input type="hidden" name="product[image]" value="{{asset('storage/' . $p->images->first()->image)}}">
									<input type="hidden" name="product[slug]" value="{{$p->slug}}">
									<input type="hidden" name="product[amount]" type="number" value="1">
									<button class="add-card"><i class="flaticon-bag"></i><span>Ao carrinho</span></button>

								@if(!$p->favorites->contains(auth()->user()))
									<button type="button" onclick="favorite({{ $p->id }}, '{{ Request::url() }}#{{ $p->id }}-{{ $p->name }}', '{{ csrf_token() }}')" class="wishlist-btn" data-toggle="tooltip" data-placement="right" title="Favoritar" ><i class="flaticon-heart"></i></button>
								@else
									<button type="button" onclick="unfavorite({{ $p->id }}, '{{ Request::url() }}#{{ $p->id }}-{{ $p->name }}', '{{ csrf_token() }}')" class="wishlist-btn" data-toggle="tooltip" data-placement="right" title="Desfavoritar"><i class="fas fa-heart"></i></button>
								@endif
							</div>
						</form>
					</div>

				<div class="pi-text">
					<h6>R$ {{number_format($p->price, 2, ',', '.')}}</h6>
					<p>{{ $p->name }}</p>
				</div>
			</div>
				@endforeach
			</div>
		</div>
	</section>
	<!-- RELATED PRODUCTS section end -->
	@section('scripts')
    <script>
        const favUrl = "{{ route('favorite') }}";
        const unfavUrl = "{{ route('unfavorite') }}";
    </script>
    @endsection
@endsection
