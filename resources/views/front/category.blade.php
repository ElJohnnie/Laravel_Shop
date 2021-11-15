@extends('layouts.categories')

@section('content')
<!-- Page info -->
<div class="page-top-info">
    @foreach ($categories as $c)
    <div class="container">
        <h4>        
            Categoria {{ $c->name }}  
        </h4>
        <div class="site-pagination">
            <a href="{{ route('home') }}">Home</a> /
            {{ $c->name }}
        </div>
    </div>
    @endforeach
</div>
<!-- Page info end -->
<!-- Category section -->
<section class="category-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-2 order-lg-1">
                <div class="filter-widget">
                    <h2 class="fw-title">
                        Menu lateral
                    </h2>
                    <ul class="category-menu">
                        @foreach ($categoriesLayouts as $menu)
                        <li>
                            <a href="{{ route('categorias', ['category' => $menu->slug]) }}">{{ $menu->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9  order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="row">
                    @foreach ($categories as $c)
                        @if($c->products->count() > 0)
                            @foreach($c->products as $p)
                                @if($p->amount <= 0)
                                
                                @else
                                    <div class="col-lg-4 col-sm-6">
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
                                    </div>
                                @endif
                            @endforeach
                        @else
                        <div class="col-12">
                            <div class="alert alert-warning" role="alert">
                                Não há produtos disponíveis para essa categoria
                            </div>
                        </div>
                        @endif
                    @endforeach
                    <!--
                    <div class="text-center w-100 pt-3">
                        <button class="site-btn sb-line sb-dark">LOAD MORE</button>
                    </div>
                -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Category section end -->
@section('scripts')
    <script>
        const favUrl = "{{ route('favorite') }}";
        const unfavUrl = "{{ route('unfavorite') }}";
    </script>
@endsection
@endsection