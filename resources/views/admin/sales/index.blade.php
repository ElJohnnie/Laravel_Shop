@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Vendas</h1>
        @include('flash::message')
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Compartilhar</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Exportar CSV</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            Este mês
            </button>
        </div>
    </div>
    @php {{ $now = \Carbon\Carbon::now()->format('d-m-y'); }} @endphp
    @include('flash::message')
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-analise-tab" data-toggle="tab" href="#aguardando" role="tab" aria-controls="nav-aguardando" aria-selected="true">Aguardando pagamento ou Em análise</a>
            <a class="nav-link" id="nav-pago-tab" data-toggle="tab" href="#pago" role="tab" aria-controls="nav-pago" aria-selected="false">Pago</a>
            <a class="nav-link" id="nav-cancelado-tab" data-toggle="tab" href="#cancelado" role="tab" aria-controls="nav-cancelado" aria-selected="false">Cancelado</a>
        </div>
    </nav>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="aguardando" role="tab" aria-labelledby="nav-aguardando">
            <div class="accordion" id="accordionExample">
                @foreach($sales as $s)
                    @if($s->pagseguro_status == 1 || $s->pagseguro_status == 2)
                        <div class="card" data-time="{{ $s->data_compra }}">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $s->reference }}" aria-expanded="true" aria-controls="collapseOne">
                                    Compra realizada por <b>{{ $s->user->name }}</b> na data de
                                        @if($s->data_compra == $now )
                                            <b>hoje</b>.
                                        @else
                                            {{ $s->data_compra }}.
                                        @endif
                                            Status de pagamento:
                                        @if($s->pagseguro_status == 1)
                                            <b style="color:red;">Aguardando pagamento</b>. 
                                        @endif
                                        @if($s->pagseguro_status == 2) 
                                            <b style="color:blue;">Em análise</b>.  
                                        @endif
                                        @if($s->pagseguro_status == 3) 
                                            <b style="color:green;">Pago</b>.  
                                        @endif
                                        @if($s->pagseguro_status == 4) 
                                            <b style="color:purple;">Cancelado</b>.  
                                        @endif
                                            Status de envio:
                                        @if($s->status_envio == false)
                                            <b style="color:red;">Não foi enviado</b>. 
                                        @else 
                                            <b style="color:green;">Enviado</b>.  
                                        @endif
                                </button>
                                </h2>
                            </div>
                            <div id="collapse{{ $s->reference }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="mb-3">Dados do pagamento</h5>
                                            <p><b>Código Pagseguro: </b>{{ $s->pagseguro_code }}</p>
                                            <p><b>Status do pagamento: </b>{{ $s->pagseguro_status }}</p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '2')" name="pagseguroStatusInputs" id="status1" value="2" @if($s->pagseguro_status == 1 or $s->pagseguro_status == 2) checked @endif>
                                                <label class="form-check-label" for="status1">Em análise</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '3')" name="pagseguroStatusInputs" id="status2" value="3">
                                                <label class="form-check-label" for="status2">Pago</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '4')" name="pagseguroStatusInputs" id="status3" value="4">
                                                <label class="form-check-label" for="status3">Venda cancelada</label>
                                            </div>
                                            <p><b>Tipo do pagamento: </b>{{ $s->type }}</p>
                                            <p><b>Se boleto, o link: </b>{{ $s->link_boleto }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-3">Dados do pedido</h5>
                                            <p><b>Código da compra: </b>{{ $s->reference }}</p>
                                            <p><b>Valor da compra: </b>R$ {{number_format($s->value, 2, ',', '.')}}</p>
                                            <p><b>Itens: </b> <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#itens{{ $s->reference }}">Ver itens</button></p>
                                            <p><b>Endereço de entrega: </b> <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#endereco{{ $s->reference }}">Ver endereço</button></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="mb-3">Dados do comprador</h5>
                                            <p><b>Nome comprador: </b>{{ $s->user->name }}</p>
                                            <p><b>CPF: </b>{{ $s->user->cpf }}</p>
                                            <p><b>E-mail: </b>{{ $s->user->email }}</p>
                                            <p><b>Celular: </b>{{ $s->user->celfone }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-3">Dados de envio</h5>
                                            <p>
                                                <div class="accordion" id="accordionExample">
                                                    <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                        <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#codigoInput" aria-expanded="true" aria-controls="collapseOne">
                                                            <b>Código de envio: {{ $s->codigo_envio }}</b>
                                                        </button>
                                                        </h2>
                                                    </div>
                                                    <div id="codigoInput" class="collapse" aria-labelledby="headingOne">
                                                        <div class="card-body">
                                                            <form action="{{ route('admin.codigo-rastreio', ['sale' => $s->id]) }}" method="POST">
                                                                @csrf
                                                            
                                                                <fieldset class="form-row" disabled="disabled">
                                                                    <div class="col">
                                                                    <input type="text" class="form-control" name="codigo" placeholder="{{ $s->codigo_envio }}">
                                                                    </div>
                                                                    <div class="col">
                                                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                                                    </div>
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="itens{{ $s->reference }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Itens</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                @php 
                                    $itens = unserialize($s->itens);
                                @endphp
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Item id</th>
                                                <th scope="col">Imagem</th>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Preço</th>
                                                <th scope="col">Quantidade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($itens as $i)
                                                <tr>
                                                    <th scope="row">{{ $i['id'] }}</th>
                                                    <td><img class="w-25" src="{{ asset($i['image']) }}" alt=""></td>
                                                    <td>{{ $i['name'] }}</td>
                                                    <td>{{ $i['price'] }}</td>
                                                    <td>{{ $i['amount'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal fade" id="endereco{{ $s->reference }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Endereço de entrega</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    @php 
                                        $billingAddress = unserialize($s->billing_address);
                                        //dd($as);
                                    @endphp
                                    <div class="row">
                                        <div class="col-12">
                                            <p><b>Rua: </b>{{ $billingAddress['address'] }}</p>
                                            <p><b>Número: </b>{{ $billingAddress['number'] }}</p>
                                            <p><b>Bairro: </b>{{ $billingAddress['district'] }}</p>
                                            <p><b>Complemento: </b>{{ $billingAddress['complement'] }}</p>
                                            <p><b>Cidade: </b>{{ $billingAddress['city'] }}</p>
                                            <p><b>Estado: </b>{{ $billingAddress['state'] }}</p>
                                            <p><b>Cep: </b>{{ $billingAddress['cep'] }}</p>
                                            <p><b>Telefone para contato: </b>{{ $billingAddress['contact'] }}</p>
                                            <button type="button" class="btn btn-light">Imprimir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="pago" role="tab" aria-labelledby="nav-pago">
            <div class="accordion" id="accordionExample">
                @foreach($sales as $s)
                    @if($s->pagseguro_status == 3)
                        <div class="card" data-time="{{ $s->data_compra }}">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $s->reference }}" aria-expanded="true" aria-controls="collapseOne">
                                    Compra realizada por <b>{{ $s->user->name }}</b> na data de
                                        @if($s->data_compra == $now )
                                            <b>hoje</b>.
                                        @else
                                            {{ $s->data_compra }}.
                                        @endif
                                            Status de pagamento:
                                            @if($s->pagseguro_status == 1)
                                            <b style="color:red;">Aguardando pagamento</b>. 
                                        @endif
                                        @if($s->pagseguro_status == 2) 
                                            <b style="color:blue;">Em análise</b>.  
                                        @endif
                                        @if($s->pagseguro_status == 3) 
                                            <b style="color:green;">Pago</b>.  
                                        @endif
                                        @if($s->pagseguro_status == 4) 
                                            <b style="color:purple;">Cancelado</b>.  
                                        @endif
                                            Status de envio:
                                        @if($s->status_envio == false)
                                            <b style="color:red;">Não foi enviado</b>. 
                                        @else 
                                            <b style="color:green;">Enviado</b>.  
                                        @endif
                                </button>
                                </h2>
                            </div>
                            <div id="collapse{{ $s->reference }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="mb-3">Dados do pagamento</h5>
                                            <p><b>Código Pagseguro: </b>{{ $s->pagseguro_code }}</p>
                                            <p><b>Status do pagamento: </b>{{ $s->pagseguro_status }}</p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '2')" name="pagseguroStatusInputs" id="status1" value="2">
                                                <label class="form-check-label" for="status1">Em análise</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '3')" name="pagseguroStatusInputs" id="status2" value="3" @if($s->pagseguro_status == 3) checked @endif>
                                                <label class="form-check-label" for="status2">Pago</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '4')" name="pagseguroStatusInputs" id="status3" value="4">
                                                <label class="form-check-label" for="status3">Venda cancelada</label>
                                            </div>
                                            <p><b>Tipo do pagamento: </b>{{ $s->type }}</p>
                                            <p><b>Se boleto, o link: </b>{{ $s->link_boleto }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-3">Dados do pedido</h5>
                                            <p><b>Código da compra: </b>{{ $s->reference }}</p>
                                            <p><b>Valor da compra: </b>R$ {{number_format($s->value, 2, ',', '.')}}</p>
                                            <p><b>Itens: </b> <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#itens{{ $s->reference }}">Ver itens</button></p>
                                            <p><b>Endereço de entrega: </b> <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#endereco{{ $s->reference }}">Ver endereço</button></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="mb-3">Dados do comprador</h5>
                                            <p><b>Nome comprador: </b>{{ $s->user->name }}</p>
                                            <p><b>CPF: </b>{{ $s->user->cpf }}</p>
                                            <p><b>E-mail: </b>{{ $s->user->email }}</p>
                                            <p><b>Celular: </b>{{ $s->user->celfone }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-3">Dados de envio</h5>
                                            <p>
                                                <div class="accordion" id="accordionExample">
                                                    <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                        <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#codigoInput" aria-expanded="true" aria-controls="collapseOne">
                                                            <b>Código de envio: {{ $s->codigo_envio }}</b>
                                                        </button>
                                                        </h2>
                                                    </div>
                                                    <div id="codigoInput" class="collapse" aria-labelledby="headingOne">
                                                        <div class="card-body">
                                                            <form action="{{ route('admin.codigo-rastreio', ['sale' => $s->id]) }}" method="POST">
                                                                @csrf
                                                            
                                                                <div class="form-row">
                                                                    <div class="col">
                                                                    <input type="text" class="form-control" name="codigo" placeholder="{{ $s->codigo_envio }}">
                                                                    </div>
                                                                    <div class="col">
                                                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="itens{{ $s->reference }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Itens</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                @php 
                                    $itens = unserialize($s->itens);
                                @endphp
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Item id</th>
                                                <th scope="col">Imagem</th>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Preço</th>
                                                <th scope="col">Quantidade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($itens as $i)
                                                <tr>
                                                    <th scope="row">{{ $i['id'] }}</th>
                                                    <td><img class="w-25" src="{{ asset($i['image']) }}" alt=""></td>
                                                    <td>{{ $i['name'] }}</td>
                                                    <td>{{ $i['price'] }}</td>
                                                    <td>{{ $i['amount'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal fade" id="endereco{{ $s->reference }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Endereço de entrega</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    @php 
                                        $billingAddress = unserialize($s->billing_address);
                                        //dd($as);
                                    @endphp
                                    <div class="row">
                                        <div class="col-12">
                                            <p><b>Rua: </b>{{ $billingAddress['address'] }}</p>
                                            <p><b>Número: </b>{{ $billingAddress['number'] }}</p>
                                            <p><b>Bairro: </b>{{ $billingAddress['district'] }}</p>
                                            <p><b>Complemento: </b>{{ $billingAddress['complement'] }}</p>
                                            <p><b>Cidade: </b>{{ $billingAddress['city'] }}</p>
                                            <p><b>Estado: </b>{{ $billingAddress['state'] }}</p>
                                            <p><b>Cep: </b>{{ $billingAddress['cep'] }}</p>
                                            <p><b>Telefone para contato: </b>{{ $billingAddress['contact'] }}</p>
                                            <button type="button" class="btn btn-light">Imprimir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="cancelado" role="tab" aria-labelledby="nav-pago">
            <div class="accordion" id="accordionExample">
                @foreach($sales as $s)
                    @if($s->pagseguro_status == 4)
                        <div class="card" data-time="{{ $s->data_compra }}">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $s->reference }}" aria-expanded="true" aria-controls="collapseOne">
                                    Compra realizada por <b>{{ $s->user->name }}</b> na data de
                                        @if($s->data_compra == $now )
                                            <b>hoje</b>.
                                        @else
                                            {{ $s->data_compra }}.
                                        @endif
                                            Status de pagamento:
                                        @if($s->pagseguro_status == 1)
                                            <b style="color:red;">Aguardando pagamento</b>. 
                                        @endif
                                        @if($s->pagseguro_status == 2) 
                                            <b style="color:blue;">Em análise</b>.  
                                        @endif
                                        @if($s->pagseguro_status == 3) 
                                            <b style="color:green;">Pago</b>.  
                                        @endif
                                        @if($s->pagseguro_status == 4) 
                                            <b style="color:purple;">Cancelado</b>.  
                                        @endif
                                            Status de envio:
                                        @if($s->status_envio == false)
                                            <b style="color:red;">Não foi enviado</b>. 
                                        @else 
                                            <b style="color:green;">Enviado</b>.  
                                        @endif
                                </button>
                                </h2>
                            </div>
                            <div id="collapse{{ $s->reference }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="mb-3">Dados do pagamento</h5>
                                            <p><b>Código Pagseguro: </b>{{ $s->pagseguro_code }}</p>
                                            <p><b>Status do pagamento: </b>{{ $s->pagseguro_status }}</p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '2')" name="pagseguroStatusInputs" id="status1" value="2" disabled>
                                                <label class="form-check-label" for="status1">Em análise</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '3')" name="pagseguroStatusInputs" id="status2" value="3" disabled>
                                                <label class="form-check-label" for="status2">Pago</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="alterPagseguroStatus('{{ $s->id }}', '{{ csrf_token() }}', '4')" name="pagseguroStatusInputs" id="status3" value="4" disabled>
                                                <label class="form-check-label" for="status3">Venda cancelada</label>
                                            </div>
                                            <p><b>Tipo do pagamento: </b>{{ $s->type }}</p>
                                            <p><b>Se boleto, o link: </b>{{ $s->link_boleto }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-3">Dados do pedido</h5>
                                            <p><b>Código da compra: </b>{{ $s->reference }}</p>
                                            <p><b>Valor da compra: </b>R$ {{number_format($s->value, 2, ',', '.')}}</p>
                                            <p><b>Itens: </b> <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#itens{{ $s->reference }}">Ver itens</button></p>
                                            <p><b>Endereço de entrega: </b> <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#endereco{{ $s->reference }}">Ver endereço</button></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="mb-3">Dados do comprador</h5>
                                            <p><b>Nome comprador: </b>{{ $s->user->name }}</p>
                                            <p><b>CPF: </b>{{ $s->user->cpf }}</p>
                                            <p><b>E-mail: </b>{{ $s->user->email }}</p>
                                            <p><b>Celular: </b>{{ $s->user->celfone }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-3">Dados de envio</h5>
                                            <p>
                                                <div class="accordion" id="accordionExample">
                                                    <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                        <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#codigoInput" aria-expanded="true" aria-controls="collapseOne">
                                                            <b>Código de envio: {{ $s->codigo_envio }}</b>
                                                        </button>
                                                        </h2>
                                                    </div>
                                                    <div id="codigoInput" class="collapse" aria-labelledby="headingOne">
                                                        <div class="card-body">
                                                            <form action="{{ route('admin.codigo-rastreio', ['sale' => $s->id]) }}" method="POST">
                                                                @csrf
                                                            
                                                                <fieldset class="form-row" disabled="disabled">
                                                                    <div class="col">
                                                                    <input type="text" class="form-control" name="codigo" placeholder="{{ $s->codigo_envio }}">
                                                                    </div>
                                                                    <div class="col">
                                                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                                                    </div>
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="itens{{ $s->reference }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Itens</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                @php 
                                    $itens = unserialize($s->itens);
                                @endphp
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Item id</th>
                                                <th scope="col">Imagem</th>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Preço</th>
                                                <th scope="col">Quantidade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($itens as $i)
                                                <tr>
                                                    <th scope="row">{{ $i['id'] }}</th>
                                                    <td><img class="w-25" src="{{ asset($i['image']) }}" alt=""></td>
                                                    <td>{{ $i['name'] }}</td>
                                                    <td>{{ $i['price'] }}</td>
                                                    <td>{{ $i['amount'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal fade" id="endereco{{ $s->reference }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Endereço de entrega</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    @php 
                                        $billingAddress = unserialize($s->billing_address);
                                        //dd($as);
                                    @endphp
                                    <div class="row">
                                        <div class="col-12">
                                            <p><b>Rua: </b>{{ $billingAddress['address'] }}</p>
                                            <p><b>Número: </b>{{ $billingAddress['number'] }}</p>
                                            <p><b>Bairro: </b>{{ $billingAddress['district'] }}</p>
                                            <p><b>Complemento: </b>{{ $billingAddress['complement'] }}</p>
                                            <p><b>Cidade: </b>{{ $billingAddress['city'] }}</p>
                                            <p><b>Estado: </b>{{ $billingAddress['state'] }}</p>
                                            <p><b>Cep: </b>{{ $billingAddress['cep'] }}</p>
                                            <p><b>Telefone para contato: </b>{{ $billingAddress['contact'] }}</p>
                                            <button type="button" class="btn btn-light">Imprimir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @section('scripts')
    <script>
        const cfsaUrl = "{{ route('admin.status.pagseguro') }}";
    </script>
    <script src="{{ asset('js/sales.js') }}"></script>
    @endsection
@endsection