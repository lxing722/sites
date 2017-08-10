<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    //
    public function customer($id){
        $customer = Customer::find($id); 
        return view('customer', compact('customer'));
    }
}
