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
                    <li> <a class="link-checked" href="{{ route('cliente.favoritos') }}">Produtos favoritados</a> </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 mb-5">
            @include('flash::message')
            <div class="card">
                <div class="card-header">
                    Seus pedidos
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Itens</th>
                                    <th scope="col">Código de rastreio</th>
                                    <th scope="col">Status do pagamento</th>
                                    <th scope="col">Segunda via boleto</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $o)
                                        <tr>
                                            <td>
                                               {{$o->data_compra}}
                                            </td>
                                            <td>
                                                R$ {{number_format($o->value, 2, ',', '.')}}
                                            </td>
                                            <td>
                                                @php $itens = unserialize($o->itens) @endphp
                                                <div class="orders-products">
                                                    @foreach($itens as $p)
                                                        <div class="card">
                                                            <img class="card-img-top" src="{{ $p['image'] }}" alt="">
                                                            <div class="card-body">
                                                            <p class="card-text">Nome: {{ $p['name'] }}</p>
                                                            <p class="card-text">Valor: {{ $p['price'] }}</p>
                                                            <p class="card-text">Quantidade: {{ $p['amount'] }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                {{ $o->codigo_envio }}
                                            </td>
                                            <td>
                                                @if($o->pagseguro_status == 1)
                                                    Aguardando pagamento.
                                                @elseif ($o->pagseguro_status == 2)
                                                    Em análise.
                                                @elseif ($o->pagseguro_status == 3)
                                                    Pago.
                                                @else
                                                    Cancelada.
                                                @endif
                                            </td>
                                            <td style="max-width:50px;">
                                                @if($o->link_boleto == true && $o->pagseguro_status != 3 && $o->pagseguro_status != 4)
                                                    <a target="_blank" href="{{ $o->link_boleto }}"><i class="fas fa-2x fa-money-check"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
