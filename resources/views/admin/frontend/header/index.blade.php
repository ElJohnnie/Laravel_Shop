@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cabeçalho</h1>
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
                <i class="fas fa-desktop"></i> Banner principais
                <a href="{{route('admin.header.create')}}" type="button" class="btn btn-sm btn-sm btn-primary btn-control-panel float-right">Inserir banner</a>
            </div>
            <div class="card-body front-card">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Imagens</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($banners)
                            @foreach($banners as $b)
                            <tr>
                                <td style="max-width: 150px;">
                                    <img class="w-100" src="{{asset('storage/' . $b->banner)}}" alt="">
                                </td>
                                <td>
                                    <div class="btn-group p-1">
                                        <a href="{{ route('admin.header.edit', ['header' => $b->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i>Editar</a>
                                        <form action="{{ route('admin.header.destroy', ['header' => $b->id]) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
