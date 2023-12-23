@extends('admin.layout.main')
@section('title', 'Category List page')
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
                                <h2 class="title-1">Admin List</h2>
                            </div>
                        </div>

                    </div>
                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8 mb-5">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-x"></i>{{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <div class="row d-flex justify-content-between align-items-center">
                        @if(request('key') != null)
                        <div class="col-4 py-1  ">
                            <small class="text-danger">Total {{$admin->total()}} results found </small>
                        </div>
                        @endif
                        <div class="ml-auto w-25 my-5">
                            <form action="{{route('admin#list')}}" class="d-flex" method="get">
                                @csrf
                                <input type="text" name="key" id="" class="form-control" placeholder="Search" value="{{request('key')}}">
                                <button class="btn btn-dark " type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                           </div>
                       </div>
                    <div class="table-responsive table-responsive-data2" >
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $a)
                                    <tr class="tr-shadow">
                                        <td class="" >
                                            @if ($a->image == null)
                                                @if ($a->gender == 'male')
                                                    <img src="{{ asset('image/default-user.webp') }}" alt=""
                                                        class=" rounded-circle">
                                                @else
                                                    <img src="{{ asset('image/default-female-user.webp') }}" alt=""
                                                        class=" rounded-circle">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $a->image) }}" alt=""
                                                    class="  rounded-circle ">
                                            @endif
                                        </td>
                                        <input type="hidden" name="" id="adminId" value="{{$a->id}}">
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->email }}</td>
                                        <td>{{ $a->gender }}</td>
                                        <td>{{ $a->phone }}</td>
                                        <td>{{ $a->address }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                            @if(Auth::user()->id == 1 && Auth::user()->id != $a->id)
                                                <select name="" id="" class="me-3 changeRole">
                                                    <option value="admin" @if($a->role == 'admin')selected @endif>Admin</option>
                                                    <option value="user" @if($a->role == 'user')selected @endif >User</option>
                                                </select>
                                            <a href=" {{route('admin#delete',$a->id)}} " class="me-1">
                                                <button class="item" data-toggle="tooltip" data-placement="top"
                                                    title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </a>
                                            @else

                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{-- {{$admin->appends(request()->query())->links()}} --}}
                        </div>
                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section('scriptSection')
<script>
    $(document).ready(function(){
      $('.changeRole').change(function(){
        $currentRole = $(this).val();
        $parentNode = $(this).parents("tr");
        $adminId = $parentNode.find('#adminId').val();
        console.log($currentRole);
        $.ajax({
            type : 'get',
            url : '/admin/ajax/changeRole',
            data : {
                'role' : $currentRole,
                'id' : $adminId,
            },
            dataType : 'json',
            success : function(response){
                if(response.message == 'success'){
                    window.location.href = "http://127.0.0.1:8000/admin/list"
                }
            }
        })
      });
    })
</script>
@endsection

// {{-- <a href="{{route('admin#changeRolePage',$a->id)}}" class="me-1">
//     <button class="item" data-toggle="tooltip" data-placement="top"
//         title="Change Role">
//         <i class="fa-solid fa-person-circle-minus"></i>
//     </button>
// </a> --}}
