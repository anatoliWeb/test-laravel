@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Contact list</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>>Email address</th>
                        <th>Phone number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <tr>
                        <td>{{$row->first_name}}</td>
                        <td>{{$row->last_name}}</td>
                        <td>{{$row->email}}</td>
                        <td>{{$row->phone}}</td>
                        <td>
                            <a href="{{route('contacts.delete',[$row->id])}}">Delete</a>/
                            <a href="{{route('contacts.show',[$row->id])}}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <a href="{{route('contacts.create')}}" class="btn btn-default" > Create </a>
        </div>
    </div>
@endsection