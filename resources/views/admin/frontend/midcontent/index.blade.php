@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Banner central</h1>
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
                <i class="fas fa-desktop"></i> Banner central
                <a href="{{route('admin.midcontent.create')}}" type="button" class="btn btn-sm btn-sm btn-primary btn-control-panel float-right">Inserir conteúdo</a>
            </div>
            <div class="card-body front-card">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Sub Título</th>
                            <th>Tag</th>
                            <th>Imagem</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contents as $c)
                            <tr>
                                <td>{{ $c->title }}</td>
                                <td>{{ $c->subtitle }}</td>
                                <td>{{ $c->tag }}</td>
                                <td style="max-width:100px;">
                                    <div class="card">
                                        <img class="card-img-top" src="{{asset('storage/' . $c->image)}}" alt="">
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group p-1">
                                        <a href="{{ route('admin.midcontent.edit', ['midcontent' => $c->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i>Editar</a>
                                        <form action="{{ route('admin.midcontent.destroy', ['midcontent' => $c->id]) }}" method="POST">
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
