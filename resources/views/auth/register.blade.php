@extends('layouts.user')

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row justify-content-center ">
        <div class="col-md-12 m-5">
            <div class="card">
                <div class="card-header">{{ __('Crie sua conta') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h5 class="card-title" align="center">Dados cadastrais</h5>
                        <p style="color: black;" align="center">Campos marcados com <span style="color: black; border-left: 4px solid red"> vermelho</span> são obrigatórios!</p>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome completo') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control important-field @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cpf" class="col-md-4 col-form-label text-md-right">{{ __('CPF') }}</label>

                            <div class="col-md-6">
                                <input id="cpf" type="text" class="form-control important-field @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus>
                                <script>
                                    function inputHandler(masks, max, event) {
                                        var c = event.target;
                                        var v = c.value.replace(/\D/g, '');
                                        var m = c.value.length > max ? 1 : 0;
                                        VMasker(c).unMask();
                                        VMasker(c).maskPattern(masks[m]);
                                        c.value = VMasker.toPattern(v, masks[m]);
                                    }
                                        var cpfMask = ['999.999.999-99', '999.999.999-99'];
                                        var cpf = document.querySelector('#cpf');
                                        VMasker(cpf).maskPattern(cpfMask[0]);
                                        cpf.addEventListener('input', inputHandler.bind(undefined, cpfMask, 14), false);

                                </script>
                                @error('cpf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cep" class="col-md-4 col-form-label text-md-right">{{ __('CEP residente') }}</label>

                            <div class="col-md-6">
                                <input id="cep" type="text" class="form-control important-field @error('cep') is-invalid @enderror" name="cep" value="{{ old('cep') }}" required autocomplete="cep" autofocus>
                                <script>
                                    function inputHandler(masks, max, event) {
                                        var c = event.target;
                                        var v = c.value.replace(/\D/g, '');
                                        var m = c.value.length > max ? 1 : 0;
                                        VMasker(c).unMask();
                                        VMasker(c).maskPattern(masks[m]);
                                        c.value = VMasker.toPattern(v, masks[m]);
                                    }
                                        var cepMask = ['99999-99999', '99999-99999'];
                                        var cep = document.querySelector('#cep');
                                        VMasker(cep).maskPattern(cepMask[0]);
                                        cep.addEventListener('input', inputHandler.bind(undefined, cepMask, 14), false);

                                </script>
                                @error('cep')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone fixo ou comercial') }}</label>

                            <div class="col-md-6">
                                <input id="phone" onkeypress="return onlynumber();" class="form-control" name="phone" value="{{ old('phone') }}">
                                <script>

                                        var telMask = ['(99) 9999-9999', '(99) 99999-9999'];
                                        var tel = document.querySelector('#phone');
                                        VMasker(tel).maskPattern(telMask[0]);
                                        tel.addEventListener('input', inputHandler.bind(undefined, telMask, 14), false);

                                </script>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="celfone" class="col-md-4 col-form-label text-md-right">{{ __('Celular') }}</label>

                            <div class="col-md-6">
                                <input id="celfone" onkeypress="return onlynumber();" class="form-control @error('celfone') is-invalid @enderror" name="celfone" value="{{ old('celfone') }}">
                                <script>

                                        var telMask = ['(99) 9999-9999', '(99) 99999-9999'];
                                        var tel = document.querySelector('#celfone');
                                        VMasker(tel).maskPattern(telMask[0]);
                                        tel.addEventListener('input', inputHandler.bind(undefined, telMask, 14), false);

                                </script>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control important-field @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control important-field @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Repita sua senha') }}</label>

                            <div class="col-md-6">
                                <input password-confirm-data-test id="password-confirm" type="password" class="form-control important-field" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button submit-register-data-test type="submit" class="site-btn sb-dark mt-1">
                                    {{ __('Confirmar') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
