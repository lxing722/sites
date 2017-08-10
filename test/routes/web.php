<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    //echo 'Hello Laravel';
});

Route::get('mypage', function () {
    $data = array(
        'var1' => 'Hamburger',
        'var2' => 'Hot Dog',
        'var3' => 'French Fries',
        'orders' => App\Order::all()
    );
    return view('mypage', $data);
    //echo 'Hello Laravel';
});

Route::get('customer/{id}', 'CustomerController@customer');
/*Route::get('customer/{id}', function ($id) {
    //$customer = App\Customer::first();  //????
    $customer = App\Customer::find($id); 
    echo $customer->name;
    echo '<ul>';
    foreach($customer->orders as $order)
        echo '<li>' . $order->name . '</li>';
    echo '</ul>';
});*/

Route::get('customer_name',function(){
    $customer = App\Customer::where('name', '=', 'Bob')->first();
    echo $customer->id;
});

Route::get('order',function(){
    $orders = App\Order::All();
    foreach($orders as $order){
        //$customer = App\Customer::find($order->customer_id);
        echo $order->name . ' belongs to ' . $order->customer->name . '<br>';
    }
});

/*Route::get('hello/{name}', function ($name) {
    //return view('welcome');
    echo 'Hello ' . $name;
});

Route::post('test', function () {
    //return view('welcome');
    echo 'I just created a item';
});

Route::get('test', function () {
    //return view('welcome');
    echo '<form action="test" method="POST">';
    echo '<input type="submit">';
    echo '<input type="hidden" value="'.csrf_token().'" name="_token">';
    echo '<input type="hidden" value="PUT" name="_method">';
    echo '</form>';
});

Route::put('test', function () {
    //return view('welcome');
    echo 'I just put an item';
});

Route::delete('delete', function () {
    //return view('welcome');
    echo 'I just delete an item';
});*/
