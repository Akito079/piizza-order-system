@extends('user.layouts.master')
@section('content')
<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($cartList as $c)
                    <tr>
                        <td><img src="{{ asset('storage/' . $c->product_image) }}" alt="" class="object-fit-cover"
                                style="width: 50px ; height:50px;"></td>
                        <td class="align-middle">{{ $c->pizza_name }}
                            <input type="hidden" name="" id="productId" value="{{ $c->product_id }}">
                        </td>
                        <input type="hidden" name="" id="cartId" value="{{$c->id}}">
                        <input type="hidden" name="" value="{{ $c->user_id }}" id="userId">
                        <td class="align-middle" id="price">{{ $c->pizza_price }} Kyats</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text"
                                    class="form-control form-control-sm bg-secondary border-0 text-center" id="qty"
                                    value="{{ $c->qty }}">

                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td id="total" class="align-middle">{{ $c->pizza_price * $c->qty }} Kyats</td>
                        <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove" id="btnRemove"><i
                                    class="fa fa-times"></i></button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                    Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="subTotalPrice">{{ $totalPrice }} Kyats</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Delivery</h6>
                        <h6 class="font-weight-medium">1000 Kyats</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="finalPrice">{{ $totalPrice + 1000 }} Kyats</h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">Proceed To
                        Checkout</button>
                    <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection
@section('scriptsource')
<script src="{{ asset('user/js/cart.js') }}"></script>
<script>
    $(document).ready(function(){
    $('#orderBtn').click(function() {
            $orderList = [];
            $random = Math.floor(Math.random() * 10000001);
            $('#dataTable tbody tr').each(function(index, row) {
                $orderList.push({
                    'user_id': $(row).find('#userId').val(),
                    'product_id': $(row).find('#productId').val(),
                    'qty': $(row).find('#qty').val(),
                    'total': Number($(row).find('#total').text().replace('Kyats', '')),
                    'order_code': 'POS' + $random
                });
            });
            
            $.ajax({
                type: 'get',
                url: 'http://127.0.0.1:8000/user/ajax/order',
                data: Object.assign({}, $orderList),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'true') {
                        window.location.href = "http://127.0.0.1:8000/user/homePage";
                    }
                }
            })
        })
        //when clear btn is clicked
        $('#clearBtn').click(function(){
            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/user/ajax/clear/cart',
                dataType : 'json',
            })
            $('#dataTable tbody tr').remove();
            $('#subTotalPrice').html('0 Kyats');
            $('#finalPrice').html('1000 Kyats');
         })
         //fa-times click event
         $('.btnRemove').click(function(){
            $parentNode = $(this).parents('tr');
            $productId = $parentNode.find('#productId').val();
            $cartId = $parentNode.find('#cartId').val();
            $.ajax({
                type : 'get',
                url  : 'http://127.0.0.1:8000/user/ajax/clear/current/product',
                data : {
                    'cart_id' : $cartId,
                    'product_id' : $productId,
                },
                dataType : 'json',
            })
            $parentNode.remove();
            $totalPrice = 0 ;
            $('#dataTable tbody tr').each(function(index,row){
                $totalPrice += Number($(row).find('#total').text().replace("Kyats",""));
            });
            $('#subTotalPrice').html(`${$totalPrice} Kyats`);
            $('#finalPrice').html(`${$totalPrice+1000} Kyats`);

    });
});
</script>
@endsection
