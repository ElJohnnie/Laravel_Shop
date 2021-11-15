@extends('layouts.user')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Área do cliente</h4>
        <div class="site-pagination">
            <a href="{{route('home')}}">Home</a> /
            Área do cliente
        </div>
    </div>
</div>
<!-- Page info end -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3 order-2 order-lg-2">
            <div class="filter-widget">
                <h2 class="fw-title">
                    Painel do cliente
                </h2>
                <ul class="category-menu">
                    <li> <a class="" href="{{ route('cliente') }}">Dados pessoais</a> </li>
                    <li> <a class="" href="{{ route('cliente.endereço') }}">Endereço</a> </li>
                    <li> <a class="" href="{{ route('cliente.pedidos') }}">Meus pedidos</a> </li>
                    <li> <a class="link-checked" href="">Produtos favoritados</a> </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 mb-5">
            @include('flash::message')
            <div class="card">
                <div class="card-header">
                    Favoritos
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($favorites as $p)
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
