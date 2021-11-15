<!-- letest product section -->
<section class="top-letest-product-section">
    <div class="container">
        <div class="section-title">
            <h2>Novidades</h2>
        </div>
        
        <div class="product-slider owl-carousel">
            @foreach($products as $p)
                @if($p->amount <= 0)
                @else
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
                @endif
            @endforeach
        </div>
    </div>
</section>
<!-- letest product section end -->