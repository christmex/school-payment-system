<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
</head>
<!-- <body class="app flex-row align-items-center"> -->
<body class="app">


  <div class="container">
    <div class="row mt-4">
        <div class="col-lg-12">
            <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Pembayaran Bulan</th>
                        <th>Nominal</th>
                        <th>Discount</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($InvoiceGroup->Invoices as $data)
                        <tr>
                            <td>{{$data->student->student_name}}</td>
                            <td>{{$data->PaymentForMonthInHumanWay}}</td>
                            <td>{{$data->AmountMoneyFormat}}</td>
                            <td>{{$data->PersonalDiscountMoneyFormat}}</td>
                            <td>{{$data->SubTotalMoneyFormat}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" align="right"><b>SubTotal</b></td>
                        <td>{{Helper::MoneyFormat($total)}}</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right"><b>Denda</b></td>
                        <td>{{Helper::MoneyFormat($fineAmount)}}</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right"><b>Discount Denda</b></td>
                        <td>{{Helper::MoneyFormat($fineDiscount)}}</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right"><b>Total Akhir</b></td>
                        <td>{{Helper::MoneyFormat($finalTotal)}}</td>
                    </tr>
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <th colspan=2>TOTAL</th>
                        <th></th>
                    </tr>
                </tfoot> -->
            </table>
        </div>
    </div>
  </div>

  

  @include(backpack_view('inc.scripts'))


</body>
</html>
