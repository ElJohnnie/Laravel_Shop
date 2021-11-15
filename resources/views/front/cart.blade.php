@extends('layouts.cart')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Seu Carrinho</h4>
        <div class="site-pagination">
            <a href="{{route('home')}}">Home</a> /
            Carrinho
        </div>
    </div>
</div>
<!-- Page info end -->
<!-- cart section end -->
<section class="cart-section spad">
    <div class="container">
       <div id="alert">

       </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-table">
                    <h3>Seu carrinho</h3>
                    <div class="cart-table-warp">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-th">Produto</th>
                                    <th class="quy-th">Quantidade</th>
                                    <th class="total-th">Preço</th>
                                    <th class="total-th">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="message-inner" colspan="4">

                                    </td>
                                </tr>
                                @php $total = 0; @endphp
                                @if($cart)
                                    @foreach ($cart as $c)
                                    <tr>
                                        <td class="product-col">
                                            <a href="{{route('produto.single', ['slug' => $c['slug'] ])}}">
                                            <img src="{{$c['image']}}" alt="">
                                            <div class="pc-title">
                                                <h4>{{ substr($c['name'], 0, 15) }}...</h4>
                                                {{-- <p>R$ {{number_format($c['price'], 2, ',', '.')}}</p> --}}
                                            </div>
                                        </td>
                                        <td class="quy-col">

                                            <div class="col"> <button onclick="removeOp({{$c['id']}})">-</button>{{ $c['amount'] }}<button onclick="addOp({{ $c['id'] }})">+</button> </div>
                                            @php

                                                $subtotal = $c['price']*$c['amount'];
                                                $total += $subtotal;
                                            @endphp
                                        </td>
                                        <td class="total-col"><h4>R$ {{number_format($subtotal, 2, ',', '.')}}</h4></td>
                                        <td class="total-col"><a href="{{ route('cart.remove', ['product' => $c['id']]) }}" class="cart-btn sb-dark sb-line">Remover</a></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="total-cost">
                        <h6>Total <span>R$ @php echo number_format($total, 2, ',', '.'); @endphp</span></h6>
                    </div>
                </div>
                @if(session()->has('cart'))
                    <a href="{{route('cart.cancel')}}" class="site-btn sb-dark mt-1">Cancelar compra</a>
                @endif
            </div>
            <div class="col-lg-4 card-right">
                <form class="promo-code-form">
                    <input type="text" placeholder="Código promocional">
                    <button>Enviar</button>
                </form>
                <a href="{{route('checkout.index')}}" class="site-btn">Finalizar compra</a>
                {{-- @foreach($sellToWhatsCEP as $stwc)
                    @if(auth()->user()->cep == $stwc)
                        <a href="{{route('checkout.whatsapp')}}" class="site-btn sb-green">Comprar pelo Whatsapp</a>
                    @endif
                @endforeach --}}
                <a href="" class="site-btn sb-dark">Continuar comprando</a>
            </div>
        </div>
    </div>
</section>
<!-- cart section end -->
<!-- letest product section -->
<section class="top-letest-product-section">
    <div class="container">
        <div class="section-title">
            <h2>CONTINUE COMPRANDO</h2>
        </div>
        <div class="product-slider owl-carousel">
            @foreach($products as $p)
                <div class="product-item" id="{{ $p->id }}-{{ $p->name }}">

                    <div class="pi-pic">
                        <a href="{{route('produto.single', ['slug' => $p->slug ])}}">
                            <img class="card-img-fit" src="{{asset('storage/' . $p->images->first()->image)}}" alt="">
                        </a>
                        <form action="{{ route('cart.add') }}" method="post">
                            <div class="pi-links">

                                    @csrf
                                    <input type="hidden" name="product[id]" value="{{$p->id}}">
                                    <input type="hidden" name="product[name]" value="{{$p->name}}">
                                    <input type="hidden" name="product[price]" value="{{$p->price}}">
                                    <input type="hidden" name="product[image]" value="{{asset('storage/' . $p->images->first()->image)}}">
                                    <input type="hidden" name="product[slug]" value="{{$p->slug}}">
                                    <input type="hidden" name="product[amount]" type="number" value="1">
                                    <button class="add-card"><i class="flaticon-bag"></i><span>Ao carrinho</span></button>

                                @if(!$p->favorites->contains(auth()->user()))
                                    <button type="button" onclick="favorite({{ $p->id }}, '{{ Request::url() }}#{{ $p->id }}-{{ $p->name }}', '{{ csrf_token() }}')" class="wishlist-btn" data-toggle="tooltip" data-placement="right" title="Favoritar" ><i class="flaticon-heart"></i></button>
                                @else
                                    <button type="button" onclick="unfavorite({{ $p->id }}, '{{ Request::url() }}#{{ $p->id }}-{{ $p->name }}', '{{ csrf_token() }}')" class="wishlist-btn" data-toggle="tooltip" data-placement="right" title="Desfavoritar"><i class="fas fa-heart"></i></button>
                                @endif
                            </div>
                        </form>
                    </div>

                <div class="pi-text">
                    <h6>R$ {{number_format($p->price, 2, ',', '.')}}</h6>
                    <p>{{ $p->name }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@section('scripts')
<script>
    const favUrl = "{{ route('favorite') }}";
    const unfavUrl = "{{ route('unfavorite') }}";
    let urlCart = '{{ route("cart.cartOp") }}';
    const token = '{{ csrf_token() }}';
</script>
@endsection

@endsection
