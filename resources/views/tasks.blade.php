@extends('layouts.app')
 
@section('content')
<v-row>
    <v-col md="2">
        <nav-bar prop-user="{{ Auth::user()->name }}"></nav-bar>
    </v-col>
    <v-col md="9">
        <router-view></router-view>
    </v-col>
</v-row>
@endsection