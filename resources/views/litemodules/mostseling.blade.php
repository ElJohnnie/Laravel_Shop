<!-- Product filter section -->
<section class="product-filter-section">
    <div class="container">
        <div class="section-title">
            <h2>Mais vendidos</h2>
        </div>
        <ul class="product-filter-menu">
            <li><button class="btn-filter sb-dark" data-cad="todas">Todas</button></li>
            @foreach($categoriesLayouts as $c)
                <li><button class="btn-filter sb-dark" data-cad="{{$c->slug}}">{{$c->name}}</button></li>
            @endforeach
        </ul>
        <div class="row">
            @foreach($products as $p)
                @foreach($p->categories as $c)
                @if($p->amount <= 0)
                
                @else
                    <div class="col-lg-3 col-sm-6 col-filter {{$c->slug}} animate__animated animate__bounce">
                        <div class="product-item">
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
                                        <a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
                                    </div>
                                </form>
                            </div>
                            <div class="pi-text">
                                <h6>R$ {{number_format($p->price, 2, ',', '.')}}</h6>
                                <p>{{ $p->name }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @endforeach
            @endforeach
        </div>
    </div>
</section>
<!-- Product filter section end -->