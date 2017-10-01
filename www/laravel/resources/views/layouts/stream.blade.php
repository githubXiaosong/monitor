@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="{{url('stream/list')}}" class="list-group-item {{ \Illuminate\Support\Facades\Request::is('stream/list') ? 'active' : '' }}">List</a>
                    <a href="{{url('stream/add')}}" class="list-group-item {{ \Illuminate\Support\Facades\Request::is('stream/add') ? 'active' : '' }} ">Add</a>
                    <a  class="list-group-item {{ \Illuminate\Support\Facades\Request::is('stream/details/*') ? 'active' : '' }}">Details</a>
                    <a  class="list-group-item {{ \Illuminate\Support\Facades\Request::is('stream/modify/*') ? 'active' : '' }}">Modify</a>
                </div>
            </div>

            <div class="col-md-10">
                @yield('content-right')
            </div>
        </div>
    </div>

@endsection



