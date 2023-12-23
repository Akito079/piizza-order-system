@extends('admin.layout.main')
@section('title', 'Order Detail Page')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content ">
    <div class="section__content section__content--p30">

        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-responsive table-responsive-data2">
                    <a href="{{route('admin#orderList')}}" class="text-dark"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="row col-6">`

                        <div class="card mt-4 ">
                            <div class="card-body">
                                <h3>Order Info</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-user "></i>Customer Name</div>
                                    <div class="col">{{strtoupper($orderList[0]->user_name)}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-hashtag "></i>Order Code</div>
                                    <div class="col">{{$orderList[0]->order_code}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-regular fa-calendar "></i>Order Date</div>
                                    <div class="col">{{$orderList[0]->created_at->format('F-j-Y')}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-regular fa-calendar "></i>Total</div>
                                    <div class="col"><i class="fa-solid fa-dollar-sign"></i>{{$order->total_price}}Kyats</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Order ID</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach ($orderList as $o)
                            <tr class="tr-shadow">
                                <td></td>
                                <td class="">{{$o->id}}</td>
                                <td class="col-2"><img src="{{asset('storage/'.$o->product_image)}}" width="100%" height="100%" class="object-fit-cover" alt=""></td>
                                <td class="">{{$o->product_name}}</td>
                                <td class="">{{$o->qty}}</td>
                                <td class="">{{$o->total}}</td>
                                <td class="">{{$o->created_at->format('F-j-Y')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- <h3 class="text-secondary text-center mt-5">There is no Product Here</h3> --}}
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
