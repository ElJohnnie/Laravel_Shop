@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Catálogo</h1>
      @include('flash::message')
      <div class="btn-toolbar mb-2 mb-md-0">
        <form class="d-flex">
          <input id="filtrar-tabela" class="form-control mr-2" type="search" placeholder="Pesquisar por nome" aria-label="Search">
        </form>
      </div>
      <div class="btn-group me-2">
        <a href="{{route('admin.categories.index')}}" type="button" class="btn btn-sm btn-warning mr-1">Ir para categorias</a>
        <a href="{{route('admin.options.index')}}" type="button" class="btn btn-sm btn-warning">Ir para opções</a>
    </div>
  </div>
  <div class="row">
    <div class="col col-md-12">
      <div class="card">
        <div class="card-header" style="color:black;">
          <i class="fas fa-box-open"></i> Produtos
          @if($category->count() == 0)
          <a href="#" type="button" class="btn btn-sm btn-info float-right">Cadastrar categorias primeiro</a>
          @else
          <a href="{{route('admin.products.create')}}" type="button" class="btn btn-sm btn-sm btn-primary btn-control-panel float-right">Cadastrar produtos</a>
          @endif
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nome</th>
                  <th>Descrição</th>
                  <th>Preço</th>
                  <th>Qtd</th>
                  <th>Imagem principal</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                @if(!$products)
                @else
                    @foreach($products as $p)
                    <tr class="product-line">
                        <td>{{$p->id}}</td>
                        <td class="product-name">{{$p->name}}</td>
                        <td>{{$p->description}}</td>
                        <td>R$  {{number_format($p->price, 2, ',', '.')}}</td>
                        <td>{{$p->amount}}</td>
                        @if(!$p->images->first())
                          <td style="max-width: 100px;"><img class="w-100" src="{{asset('img/ImageNA.png')}}" alt=""></td>
                        @else
                          <td style="max-width: 100px;"><img class="w-100" src="{{asset('storage/' . $p->images->first()->image)}}" alt=""></td>
                        @endif
                        <td>
                            <div class="btn-group p-1">
                                <a href="{{ route('admin.products.edit', ['product' => $p->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i>Editar</a>
                                <form action="{{ route('admin.products.destroy', ['product' => $p->id]) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {{$products->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
