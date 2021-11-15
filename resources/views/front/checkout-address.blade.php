@extends('layouts.checkout')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Finalizar pagamento</h4>
        <div class="site-pagination">
            <a href="{{route('cart.index')}}">Carrinho</a> /
            Endereços
        </div>
    </div>
</div>
<!-- Page info end -->
<div class="container">
	@include('flash::message')
	<div class="progress mt-5 mb-5">
		<div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
	  </div>
	  <h2>Informações de endereço</h2>
	<div class="row">
		<div class="col-8">
			<form action="{{ route('checkout.set.address') }}" method="post">
				@csrf
				<div class="card my-5">
					<div class="card-header">
						{{ __('Endereços de cobrança') }}
					</div>
					<div class="card-body">
						@if($user->billings->count() == 0)
							<div class="alert alert-danger" role="alert" >
								Você não possui endereços cadastrado.
							</div>
						@else 
						@foreach($user->billings as $b)
							<div class="form-check my-2">
								<input class="form-check-input" type="radio" name="address_id" id="addressId" value="{{ $b->id }}" checked>
								<label class="form-check-label" for="addressId">
									{{ $b->name }} {{ $b->lname }}, {{ $b->address }}, {{ $b->number }}, {{ $b->district }}, {{ $b->city }}/{{ $b->state }}, {{ $b->cep }}
								</label>
								<a href="" data-toggle="modal" data-target="#modalEnderecoEdit{{ $b->id }}">
									<i class="fas fa-pencil-alt"></i>
								</a>
							</div>
						@endforeach
						@endif
						<button type="button" class="site-btn sb-dark mt-1" data-toggle="modal" data-target="#modalEndereco">+ Cadastrar novo endereço</button>
					</div>
				</div>
				@if($user->billings->count() > 0)
				<div class="card mb-5">
					<div class="card-body">
						<button type="submit" class="site-btn sb-dark mt-1">Usar endereço selecionado</button>
					</div>
				</div>
				@endif
			</form>
		</div>
		<div class="col-4">
			<div class="checkout-cart my-5">
				<h3>Confirme seu carrinho</h3>
				<ul class="product-list">
					@php $total = 0; @endphp
						@foreach(session()->get('cart') as $c)
						<li>
							<div class="pl-thumb"><img src="{{$c['image']}}" alt=""></div>
							<h6>{{$c['name']}}</h6>
							<p>Preço unitário</p>
							<p>R$ {{number_format($c['price'], 2, ',', '.')}}</p>
						</li>
						@php
							$subtotal = $c['price']*$c['amount']; 
							$total += $subtotal;  
							
						@endphp
					@endforeach
				
				</ul>
				<ul class="price-list">
					<li>Total em produtos: R$ {{number_format($total, 2, ',', '.')}}</li>
					<li class="billingTotal"></li>
					<li class="total"></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- Modal endereço-->
<div class="modal fade" id="modalEndereco" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Cadastrar endereço</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<form method="post" action="{{ route('checkout.create.address') }}">
			@csrf
			<div class="modal-body">
				<div class="form-row">
					<div class="form-group col-md-4">
					  <label for="name">Seu nome</label>
					  <input type="text" name="name" class="form-control" id="name" required>
					</div>
					<div class="form-group col-md-4">
					  <label for="lname">Seu sobrenome</label>
					  <input type="text" name="lname" class="form-control" id="lname" required>
					</div>
					<div class="form-group col-md-4">
						<label for="contact">Contato</label>
						<input type="text" name="contact" class="form-control" id="contact" required>
						<script>
							function inputHandler(masks, max, event) {
								var c = event.target;
								var v = c.value.replace(/\D/g, '');
								var m = c.value.length > max ? 1 : 0;
								VMasker(c).unMask();
								VMasker(c).maskPattern(masks[m]);
								c.value = VMasker.toPattern(v, masks[m]);
							}
								var contactMask = ['(99) 99999-9999', '(99) 99999-9999'];
								var contact = document.querySelector('#contact');
								VMasker(contact).maskPattern(contactMask[0]);
								contact.addEventListener('input', inputHandler.bind(undefined, contactMask, 14), false);
	
						</script>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4">
						<label for="address">Rua</label>
						<input id="address" type="text" class="form-control @error('address') is-invalid @enderror"  name="address" placeholder="Rua... (somente a rua)" required  autofocus>
						@error('address')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
                        @enderror
					</div>
					<div class="form-group col-md-2">
						<label for="number">Nº</label>
						<input type="text" name="number" class="form-control" id="number" required autofocus>
						<script>
			
							var nMask = ['9999999', '9999999'];
							var n = document.querySelector('#number');
							VMasker(n).maskPattern(nMask[0]);
							n.addEventListener('input', inputHandler.bind(undefined, nMask, 8), false);

					</script>
						@error('number')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-group col-md-3">
						<label for="district">Bairro</label>
						<input id="district" type="text" class="form-control @error('district') is-invalid @enderror"  name="district" required autofocus>
						@error('district')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-group col-md-3">
						<label for="complement">Complemento</label>
						<input type="text" name="complement" class="form-control" id="complement">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-5">
						<label for="city">Cidade</label>
						<input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" required autofocus>
						@error('city')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
                        @enderror
					</div>
					<div class="form-group col-md-1">
					  	<label for="state">Estado</label>
						<select class="custom-select @error('state') is-invalid @enderror" name="state" id="state" required>
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
					<div class="form-group col-md-4">
					  <label for="cep">Cep</label>
					  <input type="text" name="cep" class="form-control @error('cep') is-invalid @enderror" id="cep">
					  <script>
			
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
					<div class="form-group col-md-2">
						<label for="country">País</label>
						<input id="country" type="text" class="form-control" readonly="readonly"  name="country" value="BRA" required>
					  </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="site-btn sb-dark mt-1" data-dismiss="modal">Fechar</button>
				<button type="submit" class="site-btn sb-dark mt-1 ml-md-auto">Cadastrar endereço</button>
			</div>
		</form>
	  </div>
	</div>
  </div>
  <!-- fim modal endereço -->
  <!-- modal edit address -->
  @foreach($user->billings as $b)
  <div class="modal fade" id="modalEnderecoEdit{{ $b->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Editar endereço</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<form method="post" action="{{ route('checkout.update.address', ['address' => $b->id]) }}">
			@csrf
			<div class="modal-body">
				<div class="form-row">
					<div class="form-group col-md-4">
					  <label for="name">Seu nome</label>
					  <input type="text" name="name" class="form-control" id="name" value="{{ $b->name }}" required>
					</div>
					<div class="form-group col-md-4">
					  <label for="lname">Seu sobrenome</label>
					  <input type="text" name="lname" class="form-control" id="lname" value="{{ $b->lname }}" required>
					</div>
					<div class="form-group col-md-4">
						<label for="contact">Contato</label>
						<input type="text" name="contact" class="form-control" id="contact" value="{{ $b->contact }}" required>
						<script>
							function inputHandler(masks, max, event) {
								var c = event.target;
								var v = c.value.replace(/\D/g, '');
								var m = c.value.length > max ? 1 : 0;
								VMasker(c).unMask();
								VMasker(c).maskPattern(masks[m]);
								c.value = VMasker.toPattern(v, masks[m]);
							}
								var contactMask = ['(99) 99999-9999', '(99) 99999-9999'];
								var contact = document.querySelector('#contact');
								VMasker(contact).maskPattern(contactMask[0]);
								contact.addEventListener('input', inputHandler.bind(undefined, contactMask, 14), false);
	
						</script>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4">
						<label for="address">Rua</label>
						<input id="address" type="text" class="form-control @error('address') is-invalid @enderror"  name="address" value="{{ $b->address }}" required  autofocus>
						@error('address')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-group col-md-2">
						<label for="number">Nº</label>
						<input type="text" name="number" class="form-control" id="number" value="{{ $b->number }}" required autofocus>
						<script>
			
							var nMask = ['9999999', '9999999'];
							var n = document.querySelector('#number');
							VMasker(n).maskPattern(nMask[0]);
							n.addEventListener('input', inputHandler.bind(undefined, nMask, 8), false);

					</script>
						@error('number')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-group col-md-3">
						<label for="district">Bairro</label>
						<input id="district" type="text" class="form-control @error('district') is-invalid @enderror"  name="district" value="{{ $b->district }}" required autofocus>
						@error('district')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-group col-md-3">
						<label for="complement">Complemento</label>
						<input type="text" name="complement" class="form-control" id="complement" value="{{ $b->complement }}">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-5">
						<label for="city">Cidade</label>
						<input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" required value="{{ $b->city }}" autofocus>
						@error('city')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-group col-md-1">
						  <label for="state">Estado</label>
						<select class="custom-select @error('state') is-invalid @enderror" name="state" id="state" value="{{ $b->state }}" required>
							<option value="{{ $b->state }}" selected>{{ $b->state }}</option>
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
					<div class="form-group col-md-4">
					  <label for="cep">Cep</label>
					  <input type="text" name="cep" class="form-control @error('cep') is-invalid @enderror" id="cep" value="{{ $b->cep }}">
					  <script>
			
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
					<div class="form-group col-md-2">
						<label for="country">País</label>
						<input id="country" type="text" class="form-control" readonly="readonly"  name="country" value="BRA" required>
					  </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="site-btn sb-dark mt-1" data-dismiss="modal">Fechar</button>
				<button type="button" onclick="deleteAddress({{ $b->id }}, '{{ csrf_token() }}', '{{ route('checkout.delete.address') }}')" class="site-btn" data-dismiss="modal">Excluir endereço</button>
				<button type="submit" class="site-btn sb-dark mt-1 ml-md-auto">Cadastrar edição</button>
			</div>
		</form>
	  </div>
	</div>
</div>
<!-- modal endereço edit end -->
@endforeach
@endsection

@section('scripts')
<script src="{{ asset('js/checkout_address.js') }}"></script>

@endsection
	

