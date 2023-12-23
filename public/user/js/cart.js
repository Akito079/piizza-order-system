$(document).ready(function(){
    //+ btn event
    $('.btn-plus').click(function(){
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find('#price').text().replace("Kyats",""));
        $qty = Number($parentNode.find('#qty').val()) ;
        $total = $price*$qty ;
        $parentNode.find('#total').html($total+" Kyats");
        //manipulating paycheck
       summaryCalculation();
    });
    $('.btn-minus').click(function(){
        //- btn event
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find('#price').text().replace("Kyats",""));
        $qty = Number($parentNode.find('#qty').val()) ;
        $total = $price*$qty ;
        $parentNode.find('#total').html($total+" Kyats");
        //manipulating final paycheck
       summaryCalculation();
    });
  
    function summaryCalculation(){
        //calculating final prize
        $totalPrice = 0 ;
        $('#dataTable tbody tr').each(function(index,row){
            $totalPrice += Number($(row).find('#total').text().replace("Kyats",""));
        });
        $('#subTotalPrice').html(`${$totalPrice} Kyats`);
        $('#finalPrice').html(`${$totalPrice+1000} Kyats`);
    }
});
