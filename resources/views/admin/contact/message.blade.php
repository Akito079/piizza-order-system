@extends('admin.layout.main')
@section('title','Contact List')
@section('content')
<div class="main-content ">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="table-responsive table-responsive-data2 ">
                    <a href="{{route('admin#userList')}}" class="text-dark"><i class="fa-solid fa-arrow-left"></i></a>
                    @foreach ($contact as $c )
                    <div class="row col-10 offset-1">`
                        <div class="card mt-4 ">
                            <div class="card-body">
                                <div class="row  align-items-center">
                                    <div class="col-6 fs-4 fw-bold">{{$c->name}}</div>
                                    <div class="col-12"> <span class="fw-bold fs-5">{{$c->subject}}</span></div>
                                </div>
                                <div class="row ">
                                    <div class="col">
                                        {{Str::words($c->message,20,'....')}}
                                    </div>
                                </div>
                            </div>
                           <a href="{{route('admin#contactDetail',$c->id)}}" class="btn btn-dark offset-10 col-2 my-3">Readmore</a>
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-3">
                        {{$contact->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
