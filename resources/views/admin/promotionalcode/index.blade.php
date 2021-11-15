@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Códigos promocionais</h1>
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
                <i class="fas fa-desktop"></i> Códigos promocionais
                <a href="{{route('admin.promotionalcode.create')}}" type="button" class="btn btn-sm btn-sm btn-primary btn-control-panel float-right">Criar um código</a>
            </div>
            <div class="card-body front-card">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Por centagem em desconto</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
