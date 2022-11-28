<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
</head>
<!-- <body class="app flex-row align-items-center"> -->
<body class="app">


  <div class="container">
    <div class="row mt-4">
        <div class="col-lg-2">
            <img src="{{asset('logo_basic.png')}}" alt="" width="70%" class="d-inline">
        </div>
        <div class="col-lg-6">
            <h2>{{$getAllSetting->where('meta_key','school_name')->first()->meta_value}}</h2>
            <p class="font-weight-bold mb-0">{{$getAllSetting->where('meta_key','school_address')->first()->meta_value}}</p>
            <p class="font-weight-bold mb-0">{{$getAllSetting->where('meta_key','school_phone')->first()->meta_value}} | {{$getAllSetting->where('meta_key','school_email')->first()->meta_value}}</p>
            <p class="font-weight-bold mb-0">{{$getAllSetting->where('meta_key','school_site')->first()->meta_value}}</p>
        </div>
        <div class="col-lg-4">
            <div class="text-right">
                <p class="font-weight-bold mb-0">Print at : {{Helper::dateFormatHumanID(date('Y-m-d'))}}</p>
                <p class="mb-0">#{{$InvoiceGroup->invoice_group_number}}</p>
                <p class="font-italic mb-0">*Denda setiap tanggal {{Helper::getActiveSchoolYear('all')->date_of_fine}} per bulan</p>
            </div>
        </div>
        <div class="col-lg-12 mt-4">
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
        <div class="col-lg-12">
            <p class="font-weight-bold font-italic">{{Terbilang::make($finalTotal,' rupiah','Terbilang *')}}</p>
        </div>
    </div>
    <div class="row mt-4 text-center">
        <div class="col-lg-6">
            <!-- <p style="margin-bottom: 15%">Penerima</p>
            <p>_____________</p> -->
        </div>
        <div class="col-lg-6">
            <p style="margin-bottom: 15%">Petugas</p>
            <p>{{backpack_user()->name}}</p>
        </div>
    </div>
  </div>

  

  @include(backpack_view('inc.scripts'))


</body>
</html>
