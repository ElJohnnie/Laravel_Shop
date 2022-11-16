<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>{{ env("APP_NAME") }}</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A Laravel Shop é uma loja de ...">
	<meta http-equiv="content-language" content="pt-br">
    <meta name="robots" content="index,follow">
    <meta name="author" content="JCODE - Soluções Web">
    <meta name="keywords" content="Maquiagem">

    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:title" content=" Laravel Shop">
    <meta property="og:image" content="{{ asset('img/bg.jpg') }}">
    <meta property="og:description" content="A Laravel Shop é uma loja de ...">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@">
    <meta name="twitter:title" content="">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:description" content="">
	<!-- Favicon -->
	<link href="" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">


	<!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/flaticon.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/animate.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>



	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>
	<!-- Header section -->
	<header class="header-section ">
		<div class="header-top">
			<nav class="navbar navbar-expand-md navbar-light">
				<div class="container">
					<div class="row">
						<div class="col-lg-2 text-center text-lg-left">
							<!-- logo -->
							<a href="{{route('home')}}" class="site-logo">
								<img src="{{ asset('img/logo.png') }}" alt="">
							</a>
						</div>
						<div class="col-xl-6 col-lg-5">
							<form action="{{ route('search') }}" method="post" class="header-search-form">
								@csrf
								<input name="search" type="text" placeholder="Pesquise em  Laravel Shop">
								<button><i class="flaticon-search"></i></button>
							</form>
						</div>
						<div class="col-xl-4 col-lg-5">
							<div class="user-panel">
								<div class="up-item">
									<ul class="navbar-nav mx-auto">
								<!-- Authentication Links -->
										@guest
											<li class="nav-item">
												<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
											</li>
											@if (Route::has('register'))
												<li class="nav-item">
													<a class="nav-link" href="{{ route('register') }}">{{ __('ou Registre-se') }}</a>
												</li>
											@endif
										@else
											<li class="nav-item dropdown">
												<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
													<i class="flaticon-profile"></i>
													{{ Auth::user()->name }} <span class="caret"></span>
												</a>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
													<a class="dropdown-item" href="{{route('cliente')}}">Acessar meus dados</a>
													@if(Auth::user()->admin == '1')
														<a class="dropdown-item" href="{{ route('admin.dashboard.index') }}">Painel administrativo</a>
													@endif
													<a class="dropdown-item" href="{{ route('logout') }}"
													onclick="event.preventDefault();
																	document.getElementById('logout-form').submit();">
														{{ __('Sair') }}
													</a>

													<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
														@csrf
													</form>
												</div>
											</li>
										@endguest
									</ul>
								</div>
								<div class="up-item">
									<div class="shopping-card">
										<i class="flaticon-bag"></i>
										<span>
											@if(session()->has('cart'))
												@php
													//para contar a quantidade geral e não só de itens
													//array_sum(array_column(session()->get('carrinho'), 'quantidade'))
												@endphp
												{{ count(session()->get('cart')) }}
											@else
												0
											@endif
										</span>
									</div>
									<a href="{{ route('cart.index') }}">Seu carrinho</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>
		<nav class="main-navbar">
			<div class="container">
				<!-- menu -->
				<ul class="main-menu">
					<li><a href="{{route('home')}}">Home</a></li>
					@foreach($categoriesLayouts as $c)
						@if($c->sub_categories->count() != null)
							<li>
								<a href="#">{{ $c->name }}</a>
								<ul class="sub-menu">
									@foreach($c->sub_categories as $cs)
										<li><a href="{{ route('sub_categorias', ['category' => $cs->slug]) }}">{{ $cs->name }}</a></li>
									@endforeach
								</ul>
							</li>
						@else
						<li><a href="{{ route('categorias', ['category' => $c->slug]) }}">{{ $c->name }}</a></li>
						@endif
					@endforeach
					<!--
					<li><a href="#">Shoes</a>
						<ul class="sub-menu">
							<li><a href="#">Sneakers</a></li>
							<li><a href="#">Sandals</a></li>
							<li><a href="#">Formal Shoes</a></li>
							<li><a href="#">Boots</a></li>
							<li><a href="#">Flip Flops</a></li>
						</ul>
					</li>
					-->
					<!--
					<li><a href="#">Pages</a>
						<ul class="sub-menu">
							<li><a href="./product.html">Product Page</a></li>
							<li><a href="./category.html">Category Page</a></li>
							<li><a href="./cart.html">Cart Page</a></li>
							<li><a href="./checkout.html">Checkout Page</a></li>
							<li><a href="./contact.html">Contact Page</a></li>
						</ul>
					</li>
					-->
				</ul>
			</div>
		</nav>
	</header>
	<!-- Header section end -->
	<!-- Hero section -->
	<main class="bg-light">
		<section class="hero-section">
			<div class="hero-slider owl-carousel">
				@forelse($banners as $b)
					@if(!$b->product_slug == null)<a href="{{route('produto.single', ['slug' => $b->product_slug ])}}">@endif
						<div class="hs-item set-bg" data-setbg="{{asset('storage/' . $b->banner  )}}">
						</div>
					@if(!$b->product_slug == null)</a>@endif
				@empty
					<div class="hs-item set-bg" data-setbg="{{ asset('img/bg.jpg') }}">
					</div>
				@endforelse
			</div>
			<!--
			<div class="container">
				<div class="slide-num-holder" id="snh-1"></div>
			</div>
		-->
		</section>
		<!-- Hero section end -->
		<!-- Features section -->
		<section class="features-section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4 p-0 feature">
						<div class="feature-inner">
							<div class="feature-icon">
								<img src="{{ asset('img/icons/1.png') }}" alt="#">
							</div>
							<h2>Pagamentos rápidos e seguros</h2>
						</div>
					</div>
					<div class="col-md-4 p-0 feature">
						<div class="feature-inner">
							<div class="feature-icon">
								<img src="{{ asset('img/icons/2.png') }}" alt="#">
							</div>
							<h2>Produtos de qualidade</h2>
						</div>
					</div>
					<div class="col-md-4 p-0 feature">
						<div class="feature-inner">
							<div class="feature-icon">
								<img src="{{ asset('img/icons/3.png') }}" alt="#">
							</div>
							<h2>Entrega confiável e rápida</h2>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Features section end -->
            @yield('content')
			<a href="{{ route('cart.index') }}" style="position:fixed;width:60px;height:60px;bottom:40px;right:40px;background-color:white;color:#333333;border-radius:50px;text-align:center;font-size:30px;box-shadow: 1px 1px 2px #888;
				z-index:1000;">
				<div class="shopping-card">
					<i class="flaticon-bag"></i>
					<span>
						@if(session()->has('cart'))
							@php
								//para contar a quantidade geral e não só de itens
								//array_sum(array_column(session()->get('carrinho'), 'quantidade'))
							@endphp
							{{ count(session()->get('cart')) }}
						@else
							0
						@endif
					</span>
				</div>
			</a>
    </main>
	<!-- Banner section end  -->
	<!-- Footer section -->
	<section class="footer-section">
		<div class="container">
			<div class="footer-logo">
				<a href="index.html"><img src="{{asset('./img/logo-light.png')}}" alt=""></a>
			</div>
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<div class="footer-widget about-widget">
						<h2>Sobre nós</h2>
						<p>Seja muito bem-vinda! Somos a Laravel Shop, uma loja de...</p>
					</div>
				</div>
				<div class="col-lg-4 col-sm-6">
					<div class="footer-widget about-widget">
						<h2>Links</h2>
						<ul>
							<li><a href="{{ route('institucional') }}">Institucional</a></li>
							<li><a target="_blank" href="https://www2.correios.com.br/sistemas/rastreamento/default.cfm">Rastrear pedidos</a></li>
							<li><a href="{{ route('lgpd') }}">Termos de uso</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-sm-6">
					<div class="footer-widget contact-widget">
						<h2>Contato</h2>
						<div class="con-info">
							<span>L.</span>
							<p> Laravel Shop</p>
						</div>
						<div class="con-info">
							<span>E.</span>
							<p>Rua 10 de Taltal, 708</p>
						</div>
						<div class="con-info">
							<span>W.</span>
							<p>51 99999-9999</p>
						</div>
						<div class="con-info">
							<span>E.</span>
							<p>contato@fortunashop.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="social-links-warp">
			<div class="container">
				<div class="social-links" align="center">
					<a target="_blank" href="" class="instagram"><i class="fab fa-instagram-square"></i><span>instagram</span></a>
					<a target="_blank" href="" class="facebook"><i class="fab fa-facebook"></i><span>facebook</span></a>
					<a target="_blank" href="" class="youtube"><i class="fab fa-tiktok"></i><span>tiktok</span></a>
				</div>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				<p class="text-white text-center mt-5"> &copy;<script>document.write(new Date().getFullYear());</script> Jcode - Soluções Web
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
			</div>
		</div>
	</section>

	<!-- Footer section end -->
	<!-- modal política de privacidade -->
	<div class="modal" tabindex="-1" id="privacidade">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title">Política de privacidade</h5>
			</div>
			<div class="modal-body">
				<blockquote>
					<p><em>Quando você cria uma conta de cliente neste website, coletamos informações pessoais para melhorar nosso serviço de finalização de compra e o atendimento ao cliente.</em></p>
					<p><em>Essas informações podem incluir:</em></p>
					<ul class="my-3">
						<li><em>Endereço para cobrança e entrega</em></li>
						<li><em>Detalhes dos pedidos (por exemplo, qual pedido e preço)</em></li>
						<li><em>Endereço de email</em></li>
						<li><em>Nome</em></li>
						<li><em>Número de telefone</em></li>
					</ul>
					<p><em>Clicando em "concordo", você aceitará nossa <a href="{{ route('lgpd') }}">política de privacidade</a>.</em></p>
				</blockquote>
			</div>
			<div class="modal-footer">
				<form method="post" action="{{ route('lgpd.ok') }}">
					@csrf
					<input type="hidden" name="concordo" value="1">
					<button type="submit" class="site-btn">Concordo</button>
				</form>
			</div>
		  </div>
		</div>
	  </div>
	  @php /*session()->forget('lgpd-ok')*/ @endphp
	  @if(session()->has('lgpd-ok'))
		<script>
			var sessionLGPD = '{{ session()->get('lgpd-ok') }}';
			console.log(sessionLGPD);
		</script>
	  @else
		<script>
			var sessionLGPD = 0;
			console.log(sessionLGPD);
		</script>
	  @endif
	<!-- fim modal política de privacidade -->
	<!--====== Javascripts & Jquery ======-->

	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>
	<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
	<script src="{{ asset('js/jquery.zoom.min.js') }}"></script>
	<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
	<script src="{{ asset('js/favorites.js') }}"></script>
	@yield('scripts')
	</body>
</html>
