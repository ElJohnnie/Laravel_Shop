@extends('layouts.app')

@section('content')
<div class="content mt-3">
    @include('flash::message')
    <div class="card form-card">
        <div class="card-header" style="color:black;">
          <i class="fas fa-box"></i> Cadastrar produtos
          <a href="{{route('admin.products.index')}}" type="button" class="btn btn-sm btn-warning float-right">Voltar</a>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-geral-tab" data-toggle="tab" href="#nav-geral" role="tab" aria-controls="nav-geral" aria-selected="true">Informações gerais</a>
                <a class="nav-link" id="nav-features-tab" data-toggle="tab" href="#nav-features" role="tab" aria-controls="nav-features" aria-selected="false">Características do produto</a>
            </div>
        </nav>
        <div class="card-body">
            <form action="{{ route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                <!--inicio tabs-input -->
                <div class="tab-content" id="nav-tabContent">
                    <!-- Início tab 1 -->
                    <div class="tab-pane fade show active" id="nav-geral" role="tabpanel" aria-labelledby="nav-geral-tab">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label>Produto</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required>

                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Título meta_tag</label>
                            <input type="text" name="meta_tag_title" class="form-control @error('meta_tag_title') is-invalid @enderror" value="{{old('meta_tag_title')}}" required>

                            @error('meta_tag_title')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Descrição meta_tag</label>
                            <input type="text" name="meta_tag_description" class="form-control @error('meta_tag_description') is-invalid @enderror" value="{{old('meta_tag_description')}}">

                            @error('meta_tag_description')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Descrição</label>
                            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}" required>

                            @error('description')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Conteúdo <span class="text-muted">(pode ser nulo)</span></label>
                            <textarea name="body" class="form-control" value="{{old('body')}}"></textarea>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label>Preço <span class="text-muted">(números com pontos, ex: 3.99 para três reais e 99 centavos)</span></label>
                                <input type="text" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{old('price')}}" required>

                                @error('price')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Opções</label>
                                    <select name="options[]" id="option-select" class="form-control" multiple>
                                        @foreach($options as $op)
                                            <option value="{{$op->id}}">{{$op->name}}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-link" onclick="clearSelectedOpt()">Nenhuma opção</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Categorias</label>
                                    <select name="categories[]" id="category-select" class="form-control" multiple>
                                        @foreach($categories as $c)
                                            @if($c->sub_categories->count() == 0)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-link" onclick="clearSelectedCat()">Nenhuma categoria</button>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Sub categorias</label>
                                    <select name="sub_categories[]" id="subcategory-select" class="form-control" multiple>
                                    @foreach($categories as $c)
                                        @foreach($c->sub_categories as $cs)
                                            <option value="{{$cs->id}}">{{ $c->name }} - {{$cs->name}}</option>
                                        @endforeach
                                    @endforeach
                                    </select>
                                    <button type="button" class="btn btn-link" onclick="clearSelectedSubCat()">Nenhuma subcategoria</button>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Quantidade <span class="text-muted">(números inteiros: 0, 1, 2)</span></label>
                                    <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{old('amount')}}" required>

                                    @error('amount')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Fotos do produto</label>
                            <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple required>
                            @error('photos.*')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Fim de tab 1 -->
                    <div class="tab-pane fade show" id="nav-features" role="tabpanel" aria-labelledby="nav-features-tab">
                        <div class="form-row">
                            <div class="col">
                                <label>Peso</label>
                                <input type="number" name="weight" class="form-control" placeholder="{{ old('weight') }}">
                            </div>
                            <div class="col">
                                <label>Comprimento</label>
                                <input type="number" name="lenght" class="form-control" placeholder="{{ old('lenght') }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label>Altura</label>
                                <input type="number" name="height" class="form-control" placeholder="{{ old('height') }}">
                            </div>
                            <div class="col">
                                <label>Largura</label>
                                <input type="number" name="width" class="form-control" placeholder="{{ old('width') }}">
                            </div>
                        </div>
                        <div class="form-row mb-4">
                            <div class="col-6">
                                <label>Diâmetro</label>
                                <input type="number" name="diameter" class="form-control" placeholder="{{ old('diameter') }}">
                            </div>
                        </div>
                    </div>
                    <!-- Fim tabs input -->
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Cadastrar Produto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
