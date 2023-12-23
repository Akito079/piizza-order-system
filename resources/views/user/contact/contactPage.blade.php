@extends('user.layouts.master')
@section('content')
<!-- Shop Start -->
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-6 offset-3 bg-white shadow-md py-3 rounded-3">
            <h3 class="fw-bold fs-2 text-center">Contact Us</h3>
            <form action="{{route('contact#send')}}" class="" method="post">
                @csrf
                <div class="row">
                    <div class="col-10 offset-1 mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror " name="name"
                            placeholder="Enter your Name" value="{{Auth::user()->name}}">
                            @error('name')
                            <div class="invalid-feedback">
                                <small class="text-danger">{{$message}}</small>
                            </div>
                            @enderror
                    </div>
                    <div class="col-10 offset-1 mb-3">
                        <label for="">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter your email"
                            value="{{Auth::user()->email}}">
                            @error('email')
                            <div class="invalid-feedback">
                                <small class="text-danger">{{$message}}</small>
                            </div>
                            @enderror
                    </div>
                    <div class="col-10 offset-1 mb-3">
                        <label for="">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" placeholder="Enter subject">
                            @error('subject')
                            <div class="invalid-feedback">
                                <small class="text-danger">{{$message}}</small>
                            </div>
                            @enderror
                    </div>
                    <div class="col-10 offset-1 mb-3">
                        <label for="">Message</label>
                        <textarea name="message" id="" class="form-control @error('message') is-invalid @enderror" cols="30" rows="10"
                            placeholder="Enter your message"></textarea>
                            @error('message')
                            <div class="invalid-feedback">
                                <small class="text-danger">{{$message}}</small>
                            </div>
                            @enderror
                    </div>
                    <div class="col-3 offset-9">
                        <input class="btn btn-dark rounded-3" type="submit" value="Send">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Shop Product End -->
</div>
</div>
<!-- Shop End -->
@endsection
