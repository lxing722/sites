<!DOCTYPE html>
<html>
<head>
    <title>Customer details</title>
</head>
<body>
    <?php
    echo $customer->name;
    echo '<ul>';
    foreach($customer->orders as $order)
        echo '<li>' . $order->name . '</li>';
    echo '</ul>';
    ?>
</body>