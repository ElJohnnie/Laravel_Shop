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
                <i class="fas fa-desktop"></i> Editar conteúdo
            </div>
            <div class="card-body front-card">
                <form action="{{ route('admin.upcontent.update', ['upcontent' => $content->id])}}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{$content->title}}" required>

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
                                <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{$content->subtitle}}" required>

                                @error('subtitle')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Selecione os produtos</label>
                                <select name="products[]" id="product-banner-select" class="form-control" multiple required>
                                    @foreach($products as $p)
                                        <option value="{{$p->id}}" @if($content->products->contains($p)) selected @endif>{{$p->name}}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-link" onclick="clearSelectedProductBanner()">Nenhum produto</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Editar conteúdo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
