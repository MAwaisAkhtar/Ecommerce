<style>
   /* Example styling for the sale flag */
.sale-flag {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: red;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: bold;
    z-index: 1;
}

</style>
<section class="product_section layout_padding">
    <div class="container">
       <div class="heading_container heading_center">
          <h2>
             Our <span>products</span>
          </h2>
          <div>
            <form action="{{ route('product_search') }}" method="POST">
               @csrf
               <input style="width: 400px" type="text" name="search" placeholder="Search Something Here">
               <input type="submit" value="Search">
            </form>
          </div>
       </div>
            @if (session()->has('message'))
                  <div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                     {{ session()->get('message') }}
                  </div>
            @endif
       <div class="row">
         @foreach ($products as $product)
          <div class="col-sm-6 col-md-4 col-lg-4">
             <div class="box">
                <div class="option_container">
                   <div class="options">
                      <a href="{{ route('product_detail',$product->id) }}" class="option1">
                      Product Details
                      </a>
                        <form action="{{ route('add_cart',$product->id) }}" method="POST">
                           @csrf
                           <div class="row">
                              <div class="col-md-4">
                                 <input style="width:55px" type="number" name="quantity" value="1" min="1" style="width: 100px">
                                 </div>
                                 <div class="col-md-4">
                                    <input type="submit" id="add-to-cart" name="sub" value="Add to Cart" >
                                 </div>
                              </div>
                        </form>
                     </div>
                </div>
                <div class="img-box">
                     @if ($product->discount_price)
                     <div class="sale-flag">Sale</div>
                     @endif
                     <img src="product/{{ $product->image }}" alt="">
                </div>
                <div class="detail-box">
                   <h5>
                     {{ $product->product_name }}
                   </h5>
                   @if ($product->discount_price)

                   <h6 style="color: red">
                        Discount Price <br>
                      ${{ $product->discount_price }}
                     </h6>
                     <h6 style="text-decoration: line-through; color:blue">
                        Price <br>
                        ${{ $product->price }}
                     </h6>
                     @else
                     <h6 style="color: blue">
                        Price <br>
                        ${{ $product->price }}
                     </h6>
                     @endif
                </div>
             </div>
          </div>
         @endforeach
          
      </div>

       <span style="padding-top: 20px">
         {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
       </span>
       <div class="btn-box">
          <a href="{{ route('products') }}">
          View All products
          </a>
       </div>
    </div>
 </section>
 