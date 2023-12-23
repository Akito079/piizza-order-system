@extends('admin.layout.main')
@section('title', 'Category List Page')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content ">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="ms-2">
                          <a href="{{route('admin#list')}}" class="text-decoration-none text-dark">
                            <i class="fa-solid fa-arrow-left" ></i></a>
                        </div>
                        <div class="card-title">
                            <h3 class="text-center title-2">Change Role</h3>
                        </div>
                        <hr>
                        <form action="{{route('admin#changeRole',$account->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1 ">
                                    @if ($account->image == null)
                                        @if ($account->gender == 'male')
                                        <img src="{{ asset('image/default-user.webp') }}" alt=""
                                        class="w-50 img-thumbnail d-block mx-auto rounded-circle mt-4  ">
                                        @else
                                        <img src="{{ asset('image/default-female-user.webp') }}" alt=""
                                        class="w-50 img-thumbnail d-block mx-auto rounded-circle mt-4  ">
                                        @endif
                                    @else
                                    <img src="{{ asset('storage/'.$account->image) }}" alt="">
                                    @endif

                                    <div class="mt-3">
                                        <button class="btn btn-dark col-12" type="submit">
                                            <i class="fa-solid fa-cloud-arrow-up me-1"></i>Change</button>
                                    </div>
                                </div>
                                <div class="row col-6  ">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name"  disabled  type="text"
                                            value="{{old('name',$account->name)}}"
                                            class="form-control @error('name') is-invalid  @enderror "
                                            aria-required="true" aria-invalid="false" placeholder="Enter your name">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <select name="role" id="" class="form-control">
                                            <option value="admin" @if($account->role == 'admin') selected @endif >Admin</option>
                                            <option value="user"@if($account->role == 'user') selected @endif >User</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" disabled  type="email"
                                            value="{{old('email',$account->email)}}"
                                            class="form-control  @error('email') is-invalid  @enderror  "
                                            aria-required="true" aria-invalid="false" placeholder="Enter your email">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone" disabled  type="number"
                                            value="{{old('phone',$account->phone)}}"
                                            class="form-control @error('phone') is-invalid @enderror  "
                                            aria-required="true" aria-invalid="false" placeholder="Enter your phone">
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Gender</label>
                                        <select name="gender" id="" disabled
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="">Choose your gender</option>
                                            <option value="male" @if($account->gender == 'male') selected @endif
                                                >Male</option>
                                            <option value="female" @if($account->gender == 'female') selected @endif
                                                >Female</option>
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <textarea name="address" id="" disabled  cols="30" rows="10"
                                            class="form-control @error('address') is-invalid @enderror">{{old('address',$account->address)}}</textarea>
                                            @error('address')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
