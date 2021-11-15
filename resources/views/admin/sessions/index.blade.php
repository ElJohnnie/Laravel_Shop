@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Sessão</h1>
        @include('flash::message')
    </div>
    <h2>Sessões ativas</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Última atividade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $activity)
                <tr>
                    <td>{{ $activity->user->name }}</td>
                    <td>{{ $activity->last_activity }}</td>
                </tr>
               @endforeach
            </tbody>

        </table>
    </div>
@endsection
