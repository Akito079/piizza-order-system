@extends('admin.layout.main')
@section('title', 'Order List Page')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content ">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="row d-flex justify-content-between align-items-center">
                    @if(request('key') != null)
                    <div class="col-4 py-1  ">
                        <small class="text-danger">Total {{count($order)}} results found </small>
                    </div>
                    @endif
                    <div class="ml-auto w-25 my-5">
                        <form action="{{route('admin#orderList')}}" class="d-flex" method="get">
                            @csrf
                            <input type="text" name="key" id="" class="form-control" placeholder="Search" value="{{request('key')}}">
                            <button class="btn btn-dark " type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                       </div>
                   </div>
                @if (count($order) != 0)
                <div class="d-flex align-items-center mb-3">
                    <select name="status" id="orderStatus" class="col-2 form-control">
                        <option value="">All</option>
                        <option value="0">
                            Pending</option>
                        <option value="1">
                            Success</option>
                        <option value="2">
                            Rejected </option>
                    </select>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Order Date</th>
                                <th>Orddr Code</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($order as $o)
                            <tr class="tr-shadow">
                                <input type="hidden" name="" id="orderId" value="{{ $o->id }}">
                                <td class="">{{ $o->user_id }}</td>
                                <td class="">{{ $o->user_name }}</td>
                                <td class="">{{ $o->created_at->format('F-j-Y') }}</td>
                               <td class=""><a href="{{route('admin#listInfo',$o->order_code)}}">{{ $o->order_code }}</a></td>
                                <td class="ammount">{{ $o->total_price }} Kyats</td>
                                <td class="">
                                    <select name="status" id="" class="form-control statusChange">
                                        <option value="0" @if ($o->status == 0) selected @endif>
                                            Pending</option>
                                        <option value="1" @if ($o->status == 1) selected @endif>
                                            Success</option>
                                        <option value="2" @if ($o->status == 2) selected @endif>
                                            Rejected </option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{-- {{ $order->appends(request()->query())->links() }} --}}
                    </div>
                </div>
                @else
                <h3 class="text-secondary text-center mt-5">There is no Order Here</h3>
                @endif
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
@section('scriptSection')
<script>
    $(document).ready(function() {
            $('#orderStatus').change(function() {
                $status = $('#orderStatus').val();
                $.ajax({
                    type: 'get',
                    url: '/orders/ajax/orderStatus',
                    data: {
                        'status': $status,
                    },
                    dataType: 'json',
                    success: function(response) {
                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $month = ['January', 'February', 'March', 'April', 'May', 'June',
                                'July', 'August', 'September', 'October', 'November',
                                'December'
                            ];
                            dbDate = new Date(response[$i].created_at);
                            $finalDate = $month[dbDate.getMonth()] + "-" + dbDate.getDate() +
                                "-" + dbDate.getFullYear();

                            if (response[$i].status == 0) {
                                $statusMessage = `<select name="status" id="" class="form-control statusChange">

                                        <option value="0" selected>
                                            Pending</option>
                                        <option value="1">
                                            Success</option>
                                        <option value="2" >
                                            Rejected </option>
                                    </select>`;
                            } else if (response[$i].status == 1) {
                                $statusMessage = `<select name="status" id="" class="form-control statusChange">
                                        <option value="0">
                                            Pending</option>
                                        <option value="1" selected>
                                            Success</option>
                                        <option value="2" >
                                            Rejected </option>
                                    </select>`;
                            } else if (response[$i].status == 2) {
                                $statusMessage = `<select name="status" id="" class="form-control statusChange">
                                        <option value="0">
                                            Pending</option>
                                        <option value="1">
                                            Success</option>
                                        <option value="2" selected >
                                            Rejected </option>
                                    </select>`;
                            }
                            $list += `
                            <tr class="tr-shadow">
                                <input type="hidden" name="" id="orderId" value="${response[$i].id}">
                                <td class="">${response[$i].user_id}</td>
                                <td class="">${response[$i].user_name}</td>
                                <td class="">${$finalDate}</td>
                               <td class="">
                                <a href="http://127.0.0.1:8000/orders/listInfo/${response[$i].order_code}">${response[$i].order_code}</a></td>
                                <td class="">${response[$i].total_price}</td>
                                <td class="">${$statusMessage}</td>
                                </tr>`;
                        }
                        $('#dataList').html($list);
                        $('.statusChange').change(function() {
                            $currentStatus = $(this).val();
                            $parentNode = $(this).parents("tr");
                            $orderId = $parentNode.find('#orderId').val();
                            $.ajax({
                                type: 'get',
                                url: '/orders/ajax/changeStatus',
                                data: {
                                    'status': $currentStatus,
                                    'orderId': $orderId,
                                },
                                dataType: 'json',

                            })
                        });
                    }
                })
            });
            $('.statusChange').change(function() {
                console.log('status');
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find('#orderId').val();
                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/orders/ajax/changeStatus',
                    data: {
                        'status': $currentStatus,
                        'orderId': $orderId,
                    },
                    dataType: 'json',
                })
            });
        });
</script>
@endsection
