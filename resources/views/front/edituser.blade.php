@extends('layouts.single')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Área do cliente</h4>
        <div class="site-pagination">
            <a href="{{route('home')}}">Home</a> /
            <a href="{{route('cliente')}}">Área do cliente</a> / Editar dados
        </div>
    </div>
</div>
<!-- Page info end -->
<div class="container">
    @include('flash::message')
    <div class="row justify-content-center ">
        <div class="col-md-12 m-5">
            <div class="card">
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
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone fixo ou comercial') }}</label>
                            <div class="col-md-6">
                                <input id="phone" onkeypress="return onlynumber();" class="form-control" name="phone" value="{{ $user->phone }}" required>
                                <script>
                                        var telMask = ['(99) 99999-9999', '(99) 9999-9999'];
                                        var tel = document.querySelector('#phone');
                                        VMasker(tel).maskPattern(telMask[0]);
                                        tel.addEventListener('input', inputHandler.bind(undefined, telMask, 14), false);
                                </script>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="celfone" class="col-md-4 col-form-label text-md-right">{{ __('Celular') }}</label>
                            <div class="col-md-6">
                                <input id="celfone" onkeypress="return onlynumber();" class="form-control @error('celfone') is-invalid @enderror" name="celfone" value="{{ $user->celfone }}" required>
                                <script>
                                
                                        var telMask = ['(99) 99999-9999', '(99) 9999-9999'];
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
                        
                        <!-- endereço -->
                        <h5 class="card-title" align="center">Endereço</h5>

                        <div class="form-group row">
                            <label for="cep" class="col-md-4 col-form-label text-md-right">{{ __('CEP') }}</label>
                            <div class="col-md-6">
                                <input id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{$user->cep}}" required autocomplete="cep" autofocus>
                                <script>
                                    
                                        var cepMask = ['99999-999', '99999-999'];
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
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Endereço') }}</label>
                            <div class="col-md-4">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"  name="address" value="{{ $user->address }}" required autocomplete="address" autofocus>
                            </div>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            <label for="number" class="col-form-label text-md-right">{{ __('Nº') }}</label>
                            <div class="col-md-1">
                                <input id="number" type="text" class="form-control @error('number') is-invalid @enderror"  name="number" value="{{ $user->number }}" required autocomplete="number" autofocus>
                                @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="complement" class="col-md-4 col-form-label text-md-right">{{ __('Complemento') }}</label>
                            <div class="col-md-6">
                                <input id="complement" type="text" class="form-control"  name="complement" value="{{$user->complement}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="district" class="col-md-4 col-form-label text-md-right">{{ __('Bairro') }}</label>
                            <div class="col-md-6">
                                <input id="district" type="text" class="form-control @error('district') is-invalid @enderror"  name="district" value="{{$user->district}}" required autofocus>
                                @error('district')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('Cidade') }}</label>
                            <div class="col-md-4">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"  name="city" value="{{ $user->city }}" required autocomplete="city" autofocus>
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="state" class="col-form-label text-md-right">{{ __('Estado') }}</label>
                            <div class="col-md-1">
                                <select class="custom-select @error('state') is-invalid @enderror" name="state" id="state" required>
                                    <option selected value="{{$user->state}}">{{$user->state}}</option>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AP">AP</option>
                                    <option value="AM">AM</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR">PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RS">RS</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SP">SP</option>
                                    <option value="SE">SE</option>
                                    <option value="TO">TO</option>
                                </select>
                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('País') }}</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" readonly="readonly"  name="country" value="BRA" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
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
