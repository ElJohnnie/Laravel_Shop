@extends('layouts.app')

@section('content')
<div class="content mt-3">
    @include('flash::message')
    <div class="card">
        <div class="card-header" style="color:black;">
            <i class="fas fa-box"></i> Editar categoria
            <a href="{{route('admin.categories.index')}}" type="button" class="btn btn-sm btn-warning float-right">Voltar</a>
        </div>
        <div class="card-body">
            <form class="form-card" action="{{ route('admin.categories.update', ['category' => $category->id])}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                @method("PUT")
                <div class="form-group form-check">
                    <input name="as_sub" type="checkbox" class="form-check-input" id="as_sub" onclick="subCategorieDisplay()">
                    <label class="form-check-label" for="as_sub">É subcategoria</label>
                </div>
                <div class="form-group subcategorie-select" style="display: none;">
                    <label>Pertence a qual categoria</label>
                    <select name="categorie" class="form-control">
                        @foreach($categories as $c)
                            @if($c->id != $category->id)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $category->name }}">

                    @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ $category->description }}">

                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Título meta_tag</label>
                    <input type="text" name="meta_tag_title" class="form-control @error('meta_tag_title') is-invalid @enderror" value="{{ $category->meta_tag_title }}">

                    @error('meta_tag_title')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Descrição meta_tag</label>
                    <input type="text" name="meta_tag_description" class="form-control @error('meta_tag_description') is-invalid @enderror" value="{{ $category->meta_tag_description }}">

                    @error('meta_tag_description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group" id="position">
                    <label>Posição</label>
                    <select name="position" id="option-select" class="form-control" required>
                        @for($i = 0; $i <= count($categories); $i++)
                            <option value="{{$i}}" @if($i == $category->position) selected @endif>{{$i}}</option>
                        @endfor
                    </select>
                    <button type="button" class="btn btn-link" onclick="clearSelectedOpt()">Nenhuma opção</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Editar Categoria</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
