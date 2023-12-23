@extends('admin.layout.main')
@section('title', 'Account Update Page')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content ">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Profile</h3>
                        </div>
                        <hr>
                        <form action="{{route('admin#update',Auth::user()->id)}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1 ">
                                    @if (Auth::user()->image == null)
                                    @if (Auth::user()->gender == 'male')
                                    <img src="{{ asset('image/default-user.webp') }}" alt=""
                                        class="w-50 img-thumbnail d-block mx-auto rounded-circle mt-4  ">
                                    @else
                                    <img src="{{ asset('image/default-female-user.webp') }}" alt=""
                                        class="w-50 img-thumbnail d-block mx-auto rounded-circle mt-4  ">
                                    @endif
                                    @else
                                    <img src="{{ asset('storage/'.Auth::user()->image) }}" width="100px" height="100px"
                                        alt=""
                                        class="object-fit-cover img-thumbnail rounded-circle d-block mx-auto mt-4  ">
                                    @endif
                                    <div class="mt-3">
                                        <input type="file" name="image" id=""
                                            class="form-control @error('image') is-invalid @enderror ">
                                        @error('image')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-dark col-12" type="submit">
                                            <i class="fa-solid fa-cloud-arrow-up me-1"></i>Update</button>
                                    </div>
                                </div>
                                <div class="row col-6  ">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text"
                                            value="{{old('name',Auth::user()->name)}}"
                                            class="form-control @error('name') is-invalid  @enderror "
                                            aria-required="true" aria-invalid="false" placeholder="Enter your name">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" type="email"
                                            value="{{old('email',Auth::user()->email)}}"
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
                                        <input id="cc-pament" name="phone" type="number"
                                            value="{{old('phone',Auth::user()->phone)}}"
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
                                        <select name="gender" id=""
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="">Choose your gender</option>
                                            <option value="male" @if(Auth::user()->gender == 'male') selected @endif
                                                >Male</option>
                                            <option value="female" @if(Auth::user()->gender == 'female') selected @endif
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
                                        <textarea name="address" id="" cols="30" rows="10"
                                            class="form-control @error('address') is-invalid @enderror">{{old('address',Auth::user()->address)}}</textarea>
                                        @error('address')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <input id="cc-pament" name="role" type="text"
                                            value="{{old('role',Auth::user()->role)}}" class="form-control "
                                            aria-required="true" aria-invalid="false" disabled>
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
