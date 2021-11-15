@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inserir banner</h1>
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
                <i class="fas fa-desktop"></i> Inserir banner
            </div>
            <div class="card-body front-card">
                <form action="{{ route('admin.header.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Link a um produto</label>
                                <select name="product_id" id="product-banner-select" class="form-control">
                                    @foreach($products as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-link" onclick="clearSelectedProductBanner()">Nenhum produto</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Imagem banner (dica: 1920 por 1080, apenas uma imagem)</label>
                                <input type="file" name="banner" id="banner-input" class="form-control @error('banner') is-invalid @enderror" required>
                                @error('banner')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                <img class="w-100" id="banner-preview" src="" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Cadastrar Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
