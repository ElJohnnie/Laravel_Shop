@extends('layouts.user')
@section('content')
<div class="container">
    @include('flash::message')
    <div class="row justify-content-center ">
        <div class="col-md-12 m-5">
            <div class="card" style="margin-top: 10vw">
                <div class="card-header">{{ __('Edite sua conta') }}</div>
                <div class="card-body">
                    <form action="{{ route('atualizar.cliente', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <h5 class="card-title" align="center">Dados cadastrais</h5>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome completo') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="name" autofocus>
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
                                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ $user->cpf }}" required autocomplete="cpf" autofocus>
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
                                <input id="cep" type="text" class="form-control important-field @error('cep') is-invalid @enderror" name="cep" value="{{ $user->cep }}" required autocomplete="cep" autofocus>
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
                                <input id="phone" onkeypress="return onlynumber();" class="form-control" name="phone" value="{{ $user->phone }}">
                                <script>
                                        var telMask = ['(99) 99999-9999', '(99) 99999-9999'];
                                        var tel = document.querySelector('#phone');
                                        VMasker(tel).maskPattern(telMask[0]);
                                        tel.addEventListener('input', inputHandler.bind(undefined, telMask, 14), false);
                                </script>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="celfone" class="col-md-4 col-form-label text-md-right">{{ __('Celular') }}</label>
                            <div class="col-md-6">
                                <input id="celfone" onkeypress="return onlynumber();" class="form-control @error('celfone') is-invalid @enderror" name="celfone" value="{{ $user->celfone }}">
                                <script>
                                
                                        var telMask = ['(99) 99999-9999', '(99) 99999-9999'];
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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="site-btn sb-dark mt-1 btn-small">
                                    {{ __('Confirmar') }}
                                </button>
                                <a href="{{ route('cliente') }}" class="site-btn mt-1 btn-small">
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
