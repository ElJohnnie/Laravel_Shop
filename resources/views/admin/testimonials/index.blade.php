@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Testemunhos</h1>
    @include('flash::message')
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ URL::previous() }}" class="btn btn-primary btn-control-panel" type="submit">Voltar</a>
        </div>
    </div>
</div>
<div class="row mx-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="color:black;">
                <i class="fas fa-desktop"></i> Testemunhos
                <a href="{{route('admin.testimonial.create')}}" type="button" class="btn btn-sm btn-sm btn-primary btn-control-panel float-right">Inserir testemunho</a>
            </div>
            <div class="card-body front-card">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Quem</th>
                            <th>O quê</th>
                            <th>Testemunho</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $t)
                        <tr>
                            <td style="max-width: 100px;">
                                <img class="w-100" src="{{ asset('storage/'. $t->image) }}" alt="">
                            </td>
                            <td>
                                {{ $t->name }}
                            </td>
                            <td>
                                {{ $t->subname }}
                            </td>
                            <td>
                                {{ $t->testimonial }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.testimonial.edit', ['testimonial' => $t->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i>Editar</a>
                                    <form action="{{ route('admin.testimonial.destroy', ['testimonial' => $t->id]) }}" method="POST">
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
