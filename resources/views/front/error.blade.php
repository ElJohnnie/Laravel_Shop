@extends('layouts.single')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <div class="site-pagination">
            <a href="{{route('home')}}">Home</a> /
            <a href="{{route('checkout.index')}}">Tentar novamente</a>
        </div>
    </div>
</div>
<!-- Page info end -->
<!-- checkout section  -->
<section class="checkout-section spad">
	<div class="container">
        <h4>Houve um erro em seu pagamento, para tentar novamente clique no botão abaixo.</h4>
        <div class="row content">
            <div class="col-12 col-xs-1 text-center">
                <p><a href="{{route('checkout.index')}}" class="site-btn sb-dark m-5">Voltar ao checkout</a></p>
                <img class="w-50 mx-auto" src="{{ asset('img/401.png') }}" alt="">
            </div>
        </div>
	</div>
</section>

@endsection

	

