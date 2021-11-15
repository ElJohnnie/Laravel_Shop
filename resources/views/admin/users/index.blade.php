@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Usuários</h1>
    @include('flash::message')
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Administrativo</th>
                <th>Ações</th>

            </tr>
        </thead>
        <tbody>
            @if(!$users)
            @else
                @foreach($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        @if($u->admin)
                            <td>Sim</td>
                        @else
                            <td>Não</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" data-toggle="modal" data-target="#view{{ $u->id }}" class="btn btn-sm btn-success m-1"><i class="fas fa-eye"></i></button>
                                @if($u->admin == 1)
                                    <a href="" class="btn btn-sm btn-primary m-1"><i class="fas fa-pen"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@foreach($users as $u)
    <div class="modal fade" id="view{{ $u->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $u->name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Cep</th>
                            <th scope="col">Data de ingresso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">{{ $u->id }}</th>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->phone }}</td>
                            <td>{{ $u->celfone }}</td>
                            <td>{{ $u->cep }}</td>
                            <td>{{ $u->created_at }}</td>
                        </tr>
                        <tr>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <p class="text-center">Pedidos</p>
                                    </tr>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($u->orders as $o)
                                        <tr>
                                            <th scope="row">{{ $o->data_compra }}</th>
                                            <td>{{ $o->value }}</td>
                                            <td>{{ $o->pagseguro_status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
@endforeach

@endsection
