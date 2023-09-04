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
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
       <div style="width: 90%; padding-left:10%" class="table-responsive">
      <table class="table">
        <tr>

            <th>Product title</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Payment status</th>
            <th>Delivery Status</th>
            <th>Image</th>
            <th>Cancel Order</th>
        </tr>
        <tbody>
            @foreach ($order as $order)
            <tr>
                <td>{{ $order->product_title }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->payment_status }}</td>
                <td>{{ $order->delievery_status }}</td>
                <td style="width: 100px; height: 50px"><img src="product/{{ $order->image }}" alt=""></td>
                @if ($order->delievery_status == 'processing')
                <td><a href="{{ route('cancel_order',$order->id) }}" onclick="return confirm('Are you sure you want to cancel this order?')" class="btn btn-danger">Cancel Order</a></td>
                @else
                    <td></td>
                @endif
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
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