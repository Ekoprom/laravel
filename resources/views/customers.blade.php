@extends('layouts.app')

@section('content')
<div class="container">
<h1>Users</h1>
   
   @if(Session::has('success'))
   <div class="alert alert-success">
       {{ Session::get('success') }}
       @php
           Session::forget('success');
       @endphp
   </div>
   @endif
{{ $storage }}
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
              </tr>
            </thead>
          <tbody>
            @foreach($data as $customer)
            <tr>
              <td>{{ $customer->id }}</td>
              <td>{{ $customer->name }}</td>
              <td>{{ $customer->email }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
    </div>
</div>
@endsection