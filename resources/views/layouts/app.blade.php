<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fortuna Shop Administrativo</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    <!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/flaticon.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/animate.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/control-panel.css') }}"/>

  <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('js/vanilla.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Fortuna Shop</a>
        <button class="navbar-toggler float-right d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
    <div id="app">
        <div class="container-fluid">
            <div class="row">
              <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                  <ul class="navbar-nav">
                    <li><!-- logo -->
                      <a href="{{ route('home') }}" class="site-logo">
                        <img src="{{ asset('img/logo.png') }}" alt="">
                      </a>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="{{ route('admin.dashboard.index') }}">
                        <i class="fas fa-2x fa-tachometer-alt"></i>
                         Dashboard
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-2x fa-box"></i>
                        Catálogo
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('admin.products.index') }}">Produtos</a>
                          <a class="dropdown-item" href="{{ route('admin.categories.index') }}">Categorias</a>
                          <a class="dropdown-item" href="{{ route('admin.options.index') }}">Opções</a>
                      </div>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.sales.index') }}">
                        <i class="fas fa-2x fa-cart-arrow-down"></i>
                        Vendas
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.promotionalcode.index') }}">
                        <i class="fas fa-2x fa-hand-holding-heart"></i>
                        Código promocional
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-2x fa-user-friends"></i>
                        Usuários
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.session.index') }}">
                        <i class="fas fa-2x fa-user-cog"></i></i>
                        Sessões ativas
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.front.index') }}">
                        <i class="fas fa-2x fa-desktop"></i>
                        Opções do site
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.testimonial.index') }}">
                        <i class="far fa-2x fa-smile-beam"></i>
                        Testemunhos
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="fas fa-2x fa-link"></i>
                        Integrações
                      </a>
                    </li>
                  </ul>

                  <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports Salvos</span>
                    <a class="link-secondary" href="#" aria-label="Add a new report">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    </a>
                  </h6>
                  <ul class="nav flex-column mb-2">
                    <!--
                    <li class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="fas fa-2x fa-file-excel"></i>
                        Mês atual
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="fas fa-2x fa-file-excel"></i>
                        Último mês
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="fas fa-2x fa-file-excel"></i>
                        Enganjamento social
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="fas fa-2x fa-file-excel"></i>
                        Cálculo fim de ano
                      </a>
                    </li>
                    -->
                  </ul>
                </div>
              </nav>
              <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                @yield('content')
              </main>
            </div>
        </div>
    </div>
    <!--====== Javascripts & Jquery ======-->

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/bannerPreview.js') }}"></script>
    <script src="{{ asset('js/control-panel.js') }}"></script>
    @yield('scripts')

</body>
</html>
