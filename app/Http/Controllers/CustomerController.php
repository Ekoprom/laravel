<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function export_pdf()
    {
      // Fetch all customers from database
  
      $data = User::get();
  
      // Send data to the view using loadView function of PDF facade
  
      $pdf = \PDF::loadView('customers', array('data' => $data));
  
      // If you want to store the generated pdf to the server then you can use the store function
  
      //$pdf->save(storage_path().'_filename.pdf');
  
      // Finally, you can download the file using download function
  
      //return $pdf->download('customers.pdf');
      return view('customers', array('data' => $data, 'storage' => 'ddd'));
    }
}
