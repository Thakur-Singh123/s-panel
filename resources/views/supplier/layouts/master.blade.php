<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Spanel | Supplier Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('public/assets/images/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('public/assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/css/supplier-common.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/all-booking.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/booking-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/new-voucher.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/tour-list.css') }}">
  </head>
  <body>
    @include('supplier.partials.sidebar')
    @yield('content')
    @include('supplier.partials.footer')
    <script>
      var base_url = '{{ url("/") }}'; 
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/assets/js/custom-ajax.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom-script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('public/assets/js/app.js') }}"></script>
    <script src="{{ asset('public/assets/js/booking-detail.js') }}"></script>
    <script src="{{ asset('public/assets/js/tour-list.js') }}"></script>
  </body>
</html>