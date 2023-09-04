<!DOCTYPE html>
<html lang="en">
  <head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Corona Admin</title>
   <!-- plugins:css -->
   <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
   <!-- endinject -->
   <!-- Plugin css for this page -->
   <link rel="stylesheet" href="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
   <link rel="stylesheet" href="{{ asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
   <!-- End plugin css for this page -->
   <!-- inject:css -->
   <!-- endinject -->
   <!-- Layout styles -->
   <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
   <!-- End layout styles -->
   <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.png') }}" />
    <style>
      .pad
      {
        padding-right: 80px;

      }
        .div_center
        {
            text-align: center;
            padding-top: 40px;
        }
        .h2_font
        {
            font-size: 40px;
            padding-bottom: 40px;
        }
        .input_color
        {
            color: black;
            padding-bottom: 40px;
        }
        label
        {
          display:inline-block;
          width: 200px;
        }
        .div_design
        {
          padding-bottom: 20px;
        }
        .f{
            width: 150px;
            height: 150px;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
       @include('admin.navbar')

        <!-- partial body -->
        <div class="main-panel">
            <div  class="content-wrapper">
              @if (session()->has('dltmsg'))
              <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                  {{ session()->get('dltmsg') }}
              </div>
              @endif
              @if (session()->has('update'))
              <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                  {{ session()->get('update') }}
              </div>
              @endif
                <h1 class="h2_font div_center">All Products</h1>
            
             <table style="padding: 85px" class="table">
                <tr>
                    <th>Product title</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Discount price</th>
                    <th>Product Image</th>
                    <th>DELETE</th>
                    <th>UPDATE</th>
                </tr>
                <tbody>
                    @foreach ($product as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount_price }}</td>
                        <td class="f">
                            <img src="/product/{{ $product->image }}" alt="no image found">
                        </td>
                        <td><a onclick="return confirm('Are you sure to delete this')" href="{{ route('delete_product',['id' => $product->id]) }}" class="btn btn-danger">Delete</a></td>
                        <td><a  href="{{ route('update_product',['id' => $product->id]) }}" class="btn btn-success">Edit</a></td>
                    </tr>
                        @endforeach
                </tbody>
             </table>
            
                
            </div>
        </div>
        <!-- body ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
   <!-- plugins:js -->
   <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
   <!-- endinject -->
   <!-- Plugin js for this page -->
   <script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script>
   <script src="{{ asset('admin/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
   <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
   <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
   <script src="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
   <!-- End plugin js for this page -->
   <!-- inject:js -->
   <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
   <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
   <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
   <script src="{{ asset('admin/assets/js/settings.js') }}"></script>
   <script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
   <!-- endinject -->
   <!-- Custom js for this page -->
   <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
   <!-- End custom js for this page -->
  </body>
</html>
