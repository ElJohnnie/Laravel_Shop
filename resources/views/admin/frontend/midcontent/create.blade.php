@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inserir conteúdo</h1>
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
                <i class="fas fa-desktop"></i> Inserir conteúdo
            </div>
            <div class="card-body front-card">
                <form action="{{ route('admin.midcontent.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" required>

                                @error('title')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub título</label>
                                <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{old('subtitle')}}" required>

                                @error('subtitle')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tag</label>
                                <input type="text" name="tag" class="form-control @error('tag') is-invalid @enderror" value="{{old('tag')}}" required>

                                @error('tag')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Imagem banner (dica: 1920 por 480, apenas uma imagem)</label>
                                <input type="file" name="image" id="banner-input" class="form-control @error('image') is-invalid @enderror" required>
                                @error('image')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                <img id="banner-preview" src="" alt="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Referência ao banner</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioMid" id="exampleRadios1" value="product">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Um produto específico
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioMid" id="exampleRadios2" value="cat">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Uma categoria
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioMid" id="exampleRadios3" value="subcat">
                                    <label class="form-check-label" for="exampleRadios3">
                                        Uma subcategoria
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group product_link" style="display:none;">
                                <label>Link a um produto</label>
                                <select name="product_id" id="product-banner-select" class="form-control" multiple>
                                    @foreach($products as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-link" onclick="clearSelectedProductBanner()">Nenhum produto</button>
                            </div>
                            <div class="form-group category_link" style="display:none;">
                                <label>Link a uma categoria</label>
                                <select name="category_id" id="category-select" class="form-control" multiple>
                                    @foreach($categories as $c)
                                        @if($c->sub_categories->count() == 0)
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-link" onclick="clearSelectedCat()">Nenhuma categoria</button>
                            </div>
                            <div class="form-group subcategory_link" style="display:none;">
                                <label>Link a uma subcategoria</label>
                                <select name="subcategory_id" id="subcategory-select" class="form-control" multiple>
                                    @foreach($categories as $c)
                                        @if($c->sub_categories->count() > 0)
                                            @foreach($c->sub_categories as $sc)
                                                <option value="{{$sc->id}}">{{ $c->name }} - {{$sc->name}}</option>
                                            @endforeach
                                        @endif
                                    @endforeach

                                </select>
                                <button type="button" class="btn btn-link" onclick="clearSelectedSubCat()">Nenhuma subcategoria</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Cadastrar conteúdo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
