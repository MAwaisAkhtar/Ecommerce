<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{ asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{ asset('home/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{ asset('home/css/responsive.css')}}" rel="stylesheet" />
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
   </head>
   <body>
      
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
   
     {{-- main body --}}

     <div class="col-sm-6 col-md-4 col-lg-4" style="margin: auto; padding:30px; width: 50% ">
      <div class="box">
         <div class="img-box">
            <img style="width: 300px; width:300px" src="/product/{{ $product->image }}" alt="">
         </div><br>
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
              <h6>Product Category: {{ $product->category }}</h6>
              <h6>Product Details: {{ $product->description }}</h6>
              <h6>Quantity: {{ $product->quantity }}</h6>
              <form action="{{ route('add_cart',$product->id) }}" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col-md-4">
                        <input type="number" name="quantity" value="1" min="1" style="width: 100px">
                        </div>
                        <div class="col-md-4">
                           <input type="submit" name="sub" value="Add to Cart" >
                        </div>
                     </div>
                  </div>
               </form>
         </div>
      </div>
   </div>
   @if($suggestedProducts->isEmpty())
   
   @else
   
      <section class="product_section layout_padding">
       <div class="container">
          <div class="heading_container heading_center">
             <h2>
                Suggested <span>products</span>
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
            @foreach ($suggestedProducts as $suggestedProduct)
             <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="box">
                   <div class="option_container">
                      <div class="options">
                         <a href="{{ route('product_detail',$suggestedProduct->id) }}" class="option1">
                         Product Details
                         </a>
                           <form action="{{ route('add_cart',$suggestedProduct->id) }}" method="POST">
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
                        @if ($suggestedProduct->discount_price)
                        <div class="sale-flag">Sale</div>
                        @endif
                        <img src="/product/{{ $suggestedProduct->image }}" alt="">
                   </div>
                   <div class="detail-box">
                      <h5>
                        {{ $suggestedProduct->product_name }}
                      </h5>
                      @if ($suggestedProduct->discount_price)
   
                      <h6 style="color: red">
                           Discount Price <br>
                         ${{ $suggestedProduct->discount_price }}
                        </h6>
                        <h6 style="text-decoration: line-through; color:blue">
                           Price <br>
                           ${{ $suggestedProduct->price }}
                        </h6>
                        @else
                        <h6 style="color: blue">
                           Price <br>
                           ${{ $suggestedProduct->price }}
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

      @endif

     {{-- end main body --}}



      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         </p>
      </div>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>