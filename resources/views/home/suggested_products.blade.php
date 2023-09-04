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
        <div class="heading_container heading_containe heading_center">
           <h2>
            Products<span> for you</span>
           </h2>
           
        </div>
             
        <div class="row">
          @foreach ($sugg_prods as $product)
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
                                  <input type="number" name="quantity" value="1" min="1" style="width: 100px">
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

        <div class="btn-box">
           <a href="{{ route('products') }}">
           View All products
           </a>
        </div>
     </div>
  </section>
  