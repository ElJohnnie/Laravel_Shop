@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categorias</h1>
    @include('flash::message')
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{route('admin.products.index')}}" type="button" class="btn btn-sm btn-warning">Voltar para produtos</a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header" style="color:black;">
        <i class="fas fa-box-open"></i> Categorias
        <a href="{{route('admin.categories.create')}}" type="button" class="btn btn-sm btn-primary btn-control-panel float-right">Cadastrar categorias</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                    @if(!$categories)
                    @else
                        @foreach($categories as $c)
                        <tr>
                            <td>{{$c->name}}</td>
                            <td>{{$c->description}}</td>
                            <td style="max-width: 50px;">
                                <div class="btn-group">
                                    @if($c->sub_categories->count() > 0)
                                        <a data-toggle="collapse" data-target="#accordion{{ $c->id }}" class="btn btn-sm btn-success"><i class="fas fa-network-wired"></i>Filhos</a>
                                    @endif
                                    <a href="{{ route('admin.categories.edit', ['category' => $c->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i>Editar</a>
                                    <form action="{{ route('admin.categories.destroy', ['category' => $c->id]) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @foreach($c->sub_categories as $cs)
                        <tr id="accordion{{ $c->id }}" class="collapse">
                            <td>{{$cs->name}}</td>
                            <td>{{$cs->description}}</td>
                            <td style="max-width: 50px;">
                                <div class="btn-group">
                                    <a href="{{ route('admin.subcategory.edit', ['category' => $cs->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i>Editar</a>
                                    <form action="{{ route('admin.subcategory.destroy', ['category' => $cs->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
