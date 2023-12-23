@extends('admin.layout.main')
@section('title','User Details')
@section('content')
<div class="main-content ">
    <div class="section__content section__content--p30">

        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-responsive table-responsive-data2 ">
                    <a href="{{route('admin#userList')}}" class="text-dark"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="row col-6 offset-3">`

                        <div class="card mt-4 ">
                            <div class="card-body">
                                <h3>User's Info</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col"> Name</div>
                                    <div class="col">{{$user->name}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">Status</div>
                                   @if ($user->status == 0)
                                   <div class="col text-danger fw-bold">Suspended</div>
                                   @else
                                   <div class="col text-success fw-bold">Active</div>
                                   @endif
                                </div>
                                <div class="row mb-3">
                                    <div class="col">Email</div>
                                    <div class="col">{{$user->email}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">Gender</div>
                                    <div class="col">{{$user->gender}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">Role</div>
                                    <div class="col">{{$user->role}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">Phone</div>
                                    <div class="col">{{$user->phone}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">Address</div>
                                    <div class="col">{{$user->address}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- <h3 class="text-secondary text-center mt-5">There is no Product Here</h3> --}}
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection
