@extends('admin.layout.main')
@section('title', 'User Lists')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content ">
    <div class="section__content section__content--p30">
        <div class="container">
            <div class="col-md-12 ">
                <!-- DATA TABLE -->
                <div class="row d-flex justify-content-between align-items-center">
                    @if(request('key') != null)
                    <div class="col-4 py-1  ">
                        <small class="text-danger">Total {{$users->total()}} results found </small>
                    </div>
                    @endif
                    <div class="ml-auto w-25 my-5">
                        <form action="{{route('admin#userList')}}" class="d-flex" method="get">
                            @csrf
                            <input type="text" name="key" id="" class="form-control" placeholder="Search" value="{{request('key')}}">
                            <button class="btn btn-dark " type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                       </div>
                   </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center ">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th> Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                           @foreach ($users as $user )
                           <tr class="tr-shadow">
                            <td class="col-2">
                                @if ($user->image == null)
                                @if ($user->gender == 'male')
                                <img src="{{asset('image/default-user.webp')}}" alt="" class="rounded-circle ">
                                @else
                                <img src="{{asset('image/default-female-user.webp')}}" alt="" class="rounded-circle ">
                                @endif
                            @else
                            <img src="{{asset('storage/'.$user->image)}}" class="w-100 h-100 object-fit-cover" alt="">
                            @endif
                                </td>
                            <input type="hidden" name="" id="userId" value="{{$user->id}}">
                            <td> {{$user->name}} <br>
                                @if($user->status == 0)
                                    <small class="text-danger">(Suspended)</small>
                                @endif
                            </td>
                            <td>{{$user->email}}</td>
                            <td>
                                <select name="" id="" @if($user->status == 0) disabled @endif class="changeRole">
                                    <option value="admin" @if($user->role == 'admin') selected @endif >Admin</option>
                                    <option value="user" @if($user->role == 'user') selected @endif >User</option>
                                </select>
                            </td>
                            <td>
                                <div class="table-data-feature">
                                @if(Auth::user()->id == 1 && Auth::user()->id != $user->id)
                                <a href="{{route('admin#userDetails',$user->id)}}" class="me-1">
                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                        title="User Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </a>
                                <a href="{{route('user#delete',$user->id)}}" class="me-1">
                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                        title="Delete">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
                                </a>
                                <a href="{{route('admin#banUser',$user->id)}}" class="me-1">
                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                        title="ban">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                </a>
                                <a href="{{route('admin#UnbanUser',$user->id)}}" class="me-1">
                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                        title="Unban">
                                        <i class="fa-regular fa-user"></i>
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
                        {{ $users->appends(request()->query())->links() }}
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
            $parentNode = $(this).parents('tr');
            $userId = $parentNode.find('#userId').val();
            $.ajax({
                type : 'get',
                url : '/user/ajax/changeRole',
                data : {
                    'role' : $currentRole,
                    'userId' : $userId,
                },
                dataType : 'json',
            })
            location.reload();
        });
    });
</script>
@endsection
