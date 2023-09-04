<!DOCTYPE html>
<html>
<head>
    {{-- sweet alert cdn --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        /* Common styles */
        .img_design {
            width: 100%;
            max-width: 200px; /* Adjust the max-width as needed */
            height: auto;
        }

        .total_design {
            font-size: 20px;
            padding: 40px;
        }

        .remove {
            padding: 30px;
        }

        .center {
            text-align: center;
            margin-top: 20px;
        }

        /* Mobile styles (up to 576px) */
        @media only screen and (max-width: 576px) {
            .div {
                padding-left: 10px;
                padding-right: 10px;
                padding-bottom: 20px;
                padding-top: 20px;
            }

            .center {
                margin-left: 0;
            }
        }

        /* Tablet styles (up to 768px) */
        @media only screen and (max-width: 768px) {
            .div {
                padding-left: 50px;
                padding-right: 50px;
                padding-bottom: 30px;
                padding-top: 30px;
            }
        }

        /* Larger screen styles (768px and above) */
        @media only screen and (min-width: 768px) {
            .div {
                padding-left: 150px;
                padding-right: 150px;
                padding-bottom: 50px;
                padding-top: 50px;
            }
        }
    </style>
</head>
<body>
@include('sweetalert::alert')
<div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->
    <div class="div">
            @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}
            </div>
            @endif
            @if (session()->has('message_order'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message_order') }}
            </div>
            @endif
            <div style="width: 100%;" class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Product title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @php
                            $total_price=0;
                        @endphp
                        @foreach ($product as $product)
                        <tr>
                        <td>{{ $product->product_title }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>${{ $product->price }}</td>
                        <td><img class="img_design" src="product/{{ $product->image }}" alt="Sorry" > </td>
                        <td ><a class="btn btn-danger" onclick="confirmation(event)" href="{{ route('remove_cart',$product->id) }}">Remove Product</a></td>
                        </tr>
                        @php
                            $total_price=$total_price+$product->price;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <h1 class="total_design"><b>Total Price : ${{ $total_price }}</b></h1>
            </div>
            <div class="center">
                <h1 style="font-size: 25px; padding-bottom: 15px;"><b>Proceed to Order</b></h1>
                <div style="padding-bottom:10px;">
                <a class="btn btn-danger" href="{{ route('cash_order') }}">Cash on Delievery</a>
                </div>
                <a class="btn btn-danger" href="{{ route('stripe',$total_price) }}">Pay using Card</a>
            </div>
         </div>
   

    {{-- sweet alert --}}

    <script>
        // Your swal function here
    </script>

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
