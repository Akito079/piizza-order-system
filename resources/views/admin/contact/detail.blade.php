@extends('admin.layout.main')
@section('title','Contact Detail')
@section('content')
<div class="main-content ">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="table-responsive table-responsive-data2 ">
                    <a href="{{route('admin#contactList')}}" class="text-dark"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="row col-10 offset-1">`
                        <div class="card mt-4 ">
                            <div class="card-body">
                                <div class="row  align-items-center">
                                    <div class="col-12 fs-4 fw-bold">Subject: {{$contact->subject}}</div>
                                    <div class="col-6 fw-bold my-2">From-{{$contact->email}}</div>
                                    <div class="col-6 text-muted text-end">{{$contact->created_at->format('F-j-Y')}}</div>
                                </div>
                                <div class="row ">
                                    <div class="col text-justify">
                                       {{ $contact->message}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
