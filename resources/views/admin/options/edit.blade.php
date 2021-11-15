@extends('layouts.app')

@section('content')
<div class="content mt-3">
    @include('flash::message')
    <div class="card">
        <div class="card-header" style="color:black;">
            <i class="fas fa-box"></i> Cadastrar Opções
            <a href="{{route('admin.options.index')}}" type="button" class="btn btn-sm btn-warning float-right">Voltar</a>
        </div>
        <div class="card-body">
            <form class="form-card" action="{{ route('admin.options.update', ['option' => $option->id]) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                @method("PUT")
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label>Tipo de opção</label>
                            <select name="type" id="category-select" class="form-control" multiple required>

                                <option value="Roupas" @if($option->type == 'Roupas') selected @endif>Roupas</option>
                                <option value="Acessórios" @if($option->type == 'Acessórios') selected @endif>Acessórios</option>
                            </select>
                            <button type="button" class="btn btn-link" onclick="clearSelectedCat()">Nenhum tipo</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nome (exemplo: P)</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $option->name }}" required>

                    @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ $option->description }}">

                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Atualizar Opção</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
