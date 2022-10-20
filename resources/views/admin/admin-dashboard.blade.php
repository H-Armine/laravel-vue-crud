@extends('layouts.app')
@section('content')
    <admin-dashboard-component :products="{{ json_encode($products) }}"></admin-dashboard-component>
@endsection
