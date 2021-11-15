@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Conteúdo abaixo</h1>
    @include('flash::message')
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.front.index') }}" class="btn btn-primary btn-control-panel" type="submit">Voltar</a>
        </div>
    </div>
</div>
<div class="row mx-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="color:black;">
                <i class="fas fa-desktop"></i> Conteúdos de cima
                <a href="{{route('admin.downcontent.create')}}" type="button" class="btn btn-sm btn-sm btn-primary btn-control-panel float-right">Inserir conteúdo</a>
            </div>
            <div class="card-body front-card">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Sub Título</th>
                            <th>Produtos selecionados</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contents as $c)
                            <tr>
                                <td>{{ $c->title }}</td>
                                <td>{{ $c->subtitle }}</td>
                                <td style="max-width:100px;">
                                    <div class="up-content-products">
                                        @foreach($c->products as $p)
                                            <div class="card">
                                                <img class="card-img-top" src="{{asset('storage/' . $p->images->first()->image)}}" alt="">
                                                <div class="card-body">
                                                  <p class="card-text">{{ $p->name }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group p-1">
                                        <a href="{{ route('admin.downcontent.edit', ['downcontent' => $c->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i>Editar</a>
                                        <form action="{{ route('admin.downcontent.destroy', ['downcontent' => $c->id]) }}" method="POST">
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
</div>
@endsection
