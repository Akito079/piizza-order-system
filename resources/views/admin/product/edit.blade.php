@extends('admin.layout.main')
@section('title', 'Category List Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content ">
        <div class="row">
            <div class="col-3 offset-7 mb-2">
                @if (session('updateSuccess'))
                <div class="">
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <i class="fa-solid fa-x"></i>{{session('updateSuccess')}}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
               </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">

                        <div class="card-body">
                            <div class="ms-2">
                                <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                            </div>
                            <div class="card-title ">

                            </div>
                            <hr>
                           <div class="row">
                            <div class="col-4 offset-1  ">
                                <img src="{{asset('storage/' .$pizza->image)}}" alt="" class="w-100 h-100 img-thumbnail object-fit-cover ">
                            </div>
                            <div class="col-7  ">
                                <h3 class="my-3 btn bg-danger text-white d-block ">{{$pizza->name}}</h3>

                                <span class="my-3 btn btn-dark btn-sm"><i class="fa-solid fs-4 fa-dollar-sign me-2"></i>{{$pizza->price}}kyats</span>
                                <span class="my-3 btn btn-dark btn-sm"><i class="fa-solid fs-4 fa-clock me-2"></i>{{$pizza->waiting_time}}min</span>
                                <span class="my-3 btn btn-dark btn-sm"><i class="fa-regular fs-4 fa-eye me-2"></i>{{$pizza->view_count}}</span>
                                <span class="my-3 btn btn-dark btn-sm"><i class="fa-solid fa-coins me-2"></i>{{$pizza->category_name}}</span>
                                <div class="my-3 "><i class="fa-solid fs-4 fa-calendar-days me-2"></i>{{$pizza->created_at->format('j-F-Y')}}</div>
                                <div class="my-3 "><i class="fa-solid fs-4 fa-file-lines me-2"></i>Details</div>
                                <div class="">{{$pizza->description}}</div>
                            </div>
                           </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

