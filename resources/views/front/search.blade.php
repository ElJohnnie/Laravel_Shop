@extends('layouts.search')

@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>        
            Produtos encontrados 
        </h4>
        <div class="site-pagination">
            <a href="{{ route('home') }}">Home</a> /
            Pesquisar
        </div>
    </div>
</div>
<!-- Page info end -->
<!-- Category section -->
<section class="category-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-9  order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="row">
                   
                        @if($products->count() > 0)
                            @foreach($products as $p)
                                @if($p->amount <= 0)
                                
                                @else
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="product-item">
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
                                                        
                                                        <a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
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
@endsection