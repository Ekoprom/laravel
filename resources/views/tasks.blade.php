@extends('layouts.app')
 
@section('content')
<v-row>
    <v-col md="2">
        <navbar-component></navbar-component>
    </v-col>
    <v-col md="9">
        <router-view></router-view>
    </v-col>
</v-row>
@endsection