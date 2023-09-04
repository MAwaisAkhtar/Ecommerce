<section class="product_section layout_padding">
    <div class="container">
       <div class="heading_container heading_center">
          <h2>
             Top <span>Categories</span>
          </h2>
          <div>
          </div>
       </div>
           
       <div class="row">
         @foreach ($categories as $category)
          <div class="col-sm-6 col-md-4 col-lg-4">
             <div class="box">
                <div class="option_container">
                   <div class="options">
                      <a href="{{ route('products_cat',$category->Category_name) }}" class="option1">
                      See Products
                      </a>
                       
                    </div>
                </div>
                <div class="img-box">
                   <img src="product/{{ $category->image }}" alt="">
                </div>
                <div class="detail-box">
                   <h5>
                     {{ $category->Category_name }}
                   </h5>
                   
                </div>
             </div>
          </div>
         @endforeach
          
       </div>

       {{-- <span style="padding-top: 20px">
         {!! $categories->withQueryString()->links('pagination::bootstrap-5') !!}
       </span> --}}
       
    </div>
 </section>