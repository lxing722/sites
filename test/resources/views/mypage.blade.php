<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h1>My Webpage</h1>
    @if($var1 == 'Hamburger')
        I love hanburgers<br>
    @endif
    {{ $var1 }}<br>
    {{ $var2 }}<br>
    {{ $var3 }}<br>
    <ul>
    @foreach($orders as $order)
        <li>{{ $order->name }}</li>
    @endforeach
    </ul>
</body>