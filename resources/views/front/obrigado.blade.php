@extends('layouts.single')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Seu Carrinho</h4>
        <div class="site-pagination">
            <a href="{{route('home')}}">Home</a> /
            Obrigado
        </div>
    </div>
</div>
<!-- Page info end -->
<!-- checkout section  -->
<section class="checkout-section spad">
	<div class="container">
        <h2 class="text-center">Muito obrigado!</h2>
        <p class="text-center">Você pode conferir o status de envio pelo seu painel de usuário ou pelo e-mail que vamos lhe enviar.</p>
        <div class="row my-5">
            <div class="col-12">
                <div class="heart"></div>
            </div>
        </div>
        <div class="row content">
            <div class="col-12 col-xs-1 text-center">
                <p><a href="{{route('home')}}" class="site-btn sb-dark m-5">Voltar ao início</a></p>
            </div>
        </div>
	</div>
</section>

@endsection

	

