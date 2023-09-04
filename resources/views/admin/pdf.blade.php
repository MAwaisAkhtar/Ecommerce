<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Order Details</h1>
    <b>Customer Name:</b> {{ $order->name }} <br><br>
    <b>Customer Email:</b> {{ $order->email }} <br><br>
    <b>Customer Phone Number:</b> {{ $order->phone }} <br><br>
    <b>Customer Address:</b> {{ $order->address }} <br><br>
    <b>Customer ID:</b> {{ $order->user_id }} <br><br>
    <b>Product Name:</b> {{ $order->name }} <br><br>
    <b>Product Price:</b> {{ $order->price }} <br><br>
    <b>Product Quantity:</b> {{ $order->quantity }} <br><br>
    <b>Payment Status:</b> {{ $order->payment_status }} <br><br>
    <b>Product ID:</b> {{ $order->product_id }} <br><br>
    <b>Product Image:</b> <br><br> <img width="200" height="200" src="product/{{ $order->image }}" alt=""> <br><br>
    
</body>
</html>