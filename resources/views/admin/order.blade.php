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
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
       @include('admin.navbar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <h1 style="text-align:center; font-size:30px; font-weight:bold">All Orders</h1>

                <div style="padding-left:70%; padding-bottom: 30px">
                  <form action="{{ route('search') }}" method="get">
                    <input type="text" style="color: black" name="search" placeholder="Search For Something">
                    <input type="submit" value="Search" class="btn btn-outline-primary">
                  </form>
                </div>

                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Product title</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Payment Status</th>
                            <th>Delievery Status</th>
                            <th>Image</th>
                            <th>Delivered</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order as $order)
                        <tr>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->product_title }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->delievery_status }}</td>
                            <td><img src="/product/{{ $order->image }}" alt="This product has no image"></td>
                            @if ($order->delievery_status == 'processing')
                            <td><a class="btn btn-primary" onclick="return confirm('Are you sure this product is delivered?')" href="{{ route('delivered',$order->id) }}">Delivered</a></td> 
                            @else
                                <td style="color: green">Yes Delivered</td>
                            @endif
                            <td><a href="{{ route('print_pdf',$order->id) }}" class="btn btn-secondary">Print Pdf</a></td>
                            <td><a href="{{ route('send_email',$order->id) }}" class="btn btn-info">Send Email</a></td>
                        </tr>
                        @empty
                        <tr>
                          <td style="font-size:25px; font-weight:bold; color: white; padding-left:40%" colspan="16">No Record Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- partial -->
        <!-- main-panel ends -->
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