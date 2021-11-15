@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cadastrar testemunho</h1>
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
                <i class="fas fa-desktop"></i>Cadastrar testemunho
            </div>
            <div class="card-body front-card">
                <form action="{{ route('admin.testimonial.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
            
                                @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>O que é</label>
                                <input type="text" name="subname" class="form-control @error('name') is-invalid @enderror" placeholder="Cliente, funcionária, etc..." value="{{old('name')}}">
            
                                @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Testemunho</label>
                                <input type="text" name="testimonial" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
            
                                @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Imagem da pessoa</label>
                                <input type="file" name="image" id="banner-input" class="form-control @error('banner') is-invalid @enderror">
                                @error('banner')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                <img class="w-50" id="banner-preview" src="" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
