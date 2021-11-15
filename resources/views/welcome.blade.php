@extends('layouts.index')
@section('content')
	@include('flash::message')
	@php if(session('notAmount')){
		$errorProduct = session()->get('errorProduct');
	}
	@endphp
	@if(session()->get('notAmount'))
	<div class="alert alert-warning alert-dismissible fade show" role="alert">
		A quantidade solicitada para {{session()->get('productName')}} não está disponível.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif
	@if(session()->get('zeroAmount'))
	<div class="alert alert-warning alert-dismissible fade show" role="alert">
		A quantidade solicitada para {{session()->get('productName')}} foi de zero.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif

	<!-- up content section -->
	@foreach($upContent as $uc)
		<section class="top-letest-product-section">
			<div class="container">
				<div class="section-title">
					<h2>{{ $uc->title }}</h2>
					<p>{{ $uc->subtitle }}</p>
				</div>

				<div class="product-slider owl-carousel">
					@foreach($uc->products as $p)
						@if($p->amount <= 0)
						@else
							<div class="product-item" id="{{ $uc->title }}-{{ $p->name }}">

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
													<button type="button" onclick="favorite({{ $p->id }}, '{{ Request::url() }}#{{ $uc->title }}-{{ $p->name }}', '{{ csrf_token() }}')" class="wishlist-btn" data-toggle="tooltip" data-placement="right" title="Favoritar" ><i class="flaticon-heart"></i></button>
												@else
													<button type="button" onclick="unfavorite({{ $p->id }}, '{{ Request::url() }}#{{ $uc->title }}-{{ $p->name }}', '{{ csrf_token() }}')" class="wishlist-btn" data-toggle="tooltip" data-placement="right" title="Desfavoritar"><i class="fas fa-heart"></i></button>
												@endif
											</div>
										</form>
									</div>

								<div class="pi-text">
									<h6>R$ {{number_format($p->price, 2, ',', '.')}}</h6>
									<p>{{ $p->name }}</p>
								</div>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</section>
	@endforeach
	<!-- up content section end -->

	<!-- middle content section -->
	@foreach($midContent as $mid)
		<section class="banner-section">
			<div class="container">
				<div class="banner set-bg" data-setbg="{{asset('storage/' . $mid->image)}}">
					<div class="tag-new">{{ $mid->tag }}</div>
					<span>{{ $mid->subtitle }}</span>
					<h2>{{ $mid->title }}</h2>
					@if($mid->products->count() > 0)
						@foreach($mid->products as $p)
							<a href="{{route('produto.single', ['slug' => $p->slug ])}}" class="site-btn">COMPRAR AGORA</a>
						@endforeach
					@endif
					@if($mid->categories->count() > 0)
						@foreach($mid->categories as $c)
							<a href="{{ route('categorias', ['category' => $c->slug]) }}" class="site-btn">COMPRAR AGORA</a>
						@endforeach
					@endif
					@if($mid->sub_categories->count() > 0)
						@foreach($mid->sub_categories as $cs)
							<a href="{{ route('sub_categorias', ['category' => $cs->slug]) }}" class="site-btn">COMPRAR AGORA</a>
						@endforeach
					@endif
				</div>
			</div>
		</section>
	@endforeach
	<!-- middle content section end -->

    <!-- up content section -->
	@foreach($downContent as $dc)
    <section class="top-letest-product-section">
        <div class="container">
            <div class="section-title">
                <h2>{{ $dc->title }}</h2>
                <p>{{ $dc->subtitle }}</p>
            </div>

            <div class="product-slider owl-carousel">
                @foreach($dc->products as $p)
                    @if($p->amount <= 0)
                    @else
                        <div class="product-item" id="{{ $dc->title }}-{{ $p->name }}">

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
                                                <button type="button" onclick="favorite({{ $p->id }}, '{{ Request::url() }}#{{ $dc->title }}-{{ $p->name }}', '{{ csrf_token() }}')" class="wishlist-btn" data-toggle="tooltip" data-placement="right" title="Favoritar" ><i class="flaticon-heart"></i></button>
                                            @else
                                                <button type="button" onclick="unfavorite({{ $p->id }}, '{{ Request::url() }}#{{ $dc->title }}-{{ $p->name }}', '{{ csrf_token() }}')" class="wishlist-btn" data-toggle="tooltip" data-placement="right" title="Desfavoritar"><i class="fas fa-heart"></i></button>
                                            @endif
                                        </div>
                                    </form>
                                </div>

                            <div class="pi-text">
                                <h6>R$ {{number_format($p->price, 2, ',', '.')}}</h6>
                                <p>{{ $p->name }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endforeach
<!-- up content section end -->
	@section('scripts')
    <script>
        const favUrl = "{{ route('favorite') }}";
        const unfavUrl = "{{ route('unfavorite') }}";
    </script>
    @endsection
@endsection
