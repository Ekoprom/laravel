<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('tasks');
    }

    public function create()
    {
        return view('createUser');
    }    

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'password' => 'required|min:5',
                'email' => 'required|email|unique:users'
            ], 
            [
                'name.required' => 'Name is required',
                'password.required' => 'Password is required'
            ]
          );
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
    
        return back()->with('success', 'User created successfully.');
    }    
}
