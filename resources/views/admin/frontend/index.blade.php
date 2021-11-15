@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Frontend</h1>
    @include('flash::message')
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">

        </div>
    </div>
</div>
<div class="row mx-5">
  <div class="col-12 contentles m-1">
    <a href="{{ route('admin.header.index') }}">
      <div class="div-title">
        <p class="front-title">Cabeçalho</p>
      </div>
    </a>
  </div>
  <div class="col-12 contentles m-1">
    <a href="{{ route('admin.upcontent.index') }}">
      <div class="div-title">
        <p class="front-title">Conteúdo de cima</p>
      </div>
    </a>
  </div>
  <div class="col-12 contentles m-1">
    <a href="{{ route('admin.midcontent.index') }}">
      <div class="div-title">
        <p class="front-title">Conteúdo do meio</p>
      </div>
    </a>
  </div>
  <div class="col-12 contentles m-1">
    <a href="{{ route('admin.downcontent.index') }}">
        <div class="div-title">
        <p class="front-title">Conteúdo abaixo</p>
        </div>
    </a>
  </div>
  <iframe src="{{ route('home') }}" style="height:600px;width:100%;" title="Iframe Example"></iframe>
</div>
@endsection
