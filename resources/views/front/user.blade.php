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
                    <li> <a class="link-checked" href="{{ route('cliente') }}">Dados pessoais</a> </li>
                    <li> <a class="" href="{{ route('cliente.endereço') }}">Endereço</a> </li>
                    <li> <a class="" href="{{ route('cliente.pedidos') }}">Meus pedidos</a> </li>
                    <li> <a class="" href="{{ route('cliente.favoritos') }}">Produtos favoritados</a> </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 mb-5">
            @include('flash::message')
            <div class="card">
                <div class="card-header">
                    Seus dados
                    <div class="btn-group float-right">
                        <a href="{{route('editar.dadospessoais', ['user' => $user->id]) }}" class="site-btn sb-dark mt-1 btn-small" ><i class="fas fa-pencil-alt"></i> Editar</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-title">Dados pessoais</h5>
                            <p class="card-text"><b>Nome:</b> {{$user->name}}</p>
                            <p class="card-text"><b>Cpf:</b> {{$user->cpf}}</p>
                            <p class="card-text"><b>Email:</b> {{$user->email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
