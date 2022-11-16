@extends('layouts.user')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Institucional</h4>
        <div class="site-pagination">
            <a href="{{route('home')}}">Home</a> /
            Institucional
        </div>
    </div>
</div>
<div class="container">
    <div class="footer-logo text-center">
        <a href="index.html"><img src="{{asset('./img/logo-light.png')}}" alt=""></a>
    </div>
    <blockquote class="blockquote">
        <h3 class="text-center">Oi linda, tudo bem?</h3>
        <p class="text-center institucional">
            <b>Seja muito bem-vinda!</b> Somos a Laravel Shop Shop, uma loja online. Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum.
        </p>
    </blockquote>
    <blockquote class="blockquote">
        <h3 class="text-center">Nosso propósito 💕</h3>
        <p class="text-center institucional">
            <b>Missão:</b> Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
        </p>
        <p class="text-center institucional">
           <b>Visão:</b> Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
        </p>
        <p class="text-center institucional"><b>Valores:</b>
            <ul class="text-center list-unstyled">
                <li>- Empatia;</li>
                <li>- Respeito;</li>
                <li>- Inovação:</li>
                <li>- Confiança:</li>
                <li>- Ética.</li>
            </ul>
        </p>

    </blockquote>
</div>
<!-- Page info end -->
@endsection
