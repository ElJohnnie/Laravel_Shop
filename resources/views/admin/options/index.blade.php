@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Opções</h1>
    @include('flash::message')
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{route('admin.products.index')}}" type="button" class="btn btn-sm btn-warning">Ir para produtos</a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header" style="color:black;">
        <i class="fas fa-box-open"></i> Opções
        <a href="{{ route('admin.options.create') }}" type="button" class="btn btn-sm btn-primary btn-control-panel float-right">Cadastrar opções</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($options as $op)
                     <tr>
                         <td>
                             {{ $op->type }}
                         </td>
                         <td>
                            {{ $op->name }}
                         </td>
                         <td>
                            {{ $op->description }}
                         </td>
                         <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.options.edit', ['option' => $op->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i>Editar</a>
                                <form action="{{ route('admin.options.destroy', ['option' => $op->id]) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>Excluir</button>
                                </form>
                            </div>
                         </td>
                     </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
