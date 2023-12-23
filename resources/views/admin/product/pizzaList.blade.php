@extends('admin.layout.main')
@section('title','Product List Page')
@section('content')
            <!-- MAIN CONTENT-->
            <div class="main-content ">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <!-- DATA TABLE -->
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Product List</h2>
                                    </div>
                                </div>
                                <div class="table-data__tool-right">
                                    <a href="{{route('product#createPage')}}">
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>add product
                                        </button>
                                    </a>
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        CSV download
                                    </button>
                                </div>
                            </div>
                           @if (session('deleteSuccess'))
                           <div class="col-4 offset-8 mb-5">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-x"></i>{{session('deleteSuccess')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                          </div>
                           @endif
                           <div class="row d-flex justify-content-between align-items-center">
                            @if(request('key') != null)
                            <div class="col-4 py-1  ">
                                <small class="text-danger">Total {{$pizzas->total()}} results found </small>
                            </div>
                            @endif
                            <div class="ml-auto w-25 my-5">
                                <form action="{{route('products#list')}}" class="d-flex" method="get">
                                    @csrf
                                    <input type="text" name="key" id="" class="form-control" placeholder="Search" value="{{request('key')}}">
                                    <button class="btn btn-dark " type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                               </div>
                           </div>
                            @if(count($pizzas)!=0)
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2 text-center">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>View Count</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pizzas as $pizza )

                                        <tr class="tr-shadow">
                                            <td class="col-2"><img src="{{asset('storage/'. $pizza->image)}}" alt="" class=" w-100 h-100 object-fit-cover "></td>
                                            <td  class="col-3">{{$pizza->name}}</td>
                                            <td class="col-2">{{$pizza->price}}</td>
                                            <td class="col-2">{{$pizza->category_name}}</td>
                                            <td class="col-2"><i class="fa-solid fa-eye"></i>{{$pizza->view_count }}</td>
                                            <td class="col-2">
                                                <div class="table-data-feature">
                                                    <a href="{{route('product#edit',$pizza->id)}}" class="me-1">
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="View">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{route('product#updatePage',$pizza->id)}}" class="me-1">
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{route('product#delete',$pizza->id)}}" class="me-1">
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{$pizzas->links()}}
                                </div>
                            </div>
                            @else
                            <h3 class="text-secondary text-center mt-5">There is no Product Here</h3>
                            @endif
                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->


@endsection
