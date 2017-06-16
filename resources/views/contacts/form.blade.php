@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email" value="{{empty($email)?"":$email}}">
                </div>

                <div class="form-group">
                    <label for="exampleInputFirstName">First name</label>
                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="First name" name="first_name" value="{{empty($first_name)?"":$first_name}}">
                </div>

                <div class="form-group">
                    <label for="exampleInputLastName">Last name</label>
                    <input type="text" class="form-control" id="exampleInputLastName" placeholder="Last name" name="last_name" value="{{empty($last_name)?"":$last_name}}">
                </div>

                <div class="form-group">
                    <label for="exampleInputPhoneNumber">Phone number</label>
                    <input type="text" class="form-control" id="exampleInputPhoneNumber" placeholder="First name" name="phone" value="{{empty($phone)?"":$phone}}">
                </div>

                {{ csrf_field() }}
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
@endsection