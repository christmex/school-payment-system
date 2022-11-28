<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
    <style>
        @media print {
            img {
                width: 100%;
            }
            /* table th {
                border: 2px solid black!important;
            }
            table * {
                font-size: 1.2em;
            } */
        }
    </style>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print"> -->
</head>
<!-- <body class="app flex-row align-items-center"> -->
<body class="app">
  <div class="container">
    <div class="row mt-4">
        <div class="col-2">
            <img src="{{asset('logo_basic.png')}}" alt="" width="70%" class="d-inline">
        </div>
        <div class="col-6">
            <h3>{{$getAllSetting->where('meta_key','school_name')->first()->meta_value}}</h3>
            <p class="font-weight-bold mb-0">{{$getAllSetting->where('meta_key','school_address')->first()->meta_value}}</p>
            <p class="font-weight-bold mb-0">{{$getAllSetting->where('meta_key','school_phone')->first()->meta_value}} | {{$getAllSetting->where('meta_key','school_email')->first()->meta_value}}</p>
            <p class="font-weight-bold mb-0">{{$getAllSetting->where('meta_key','school_site')->first()->meta_value}}</p>
        </div>
        <div class="col-4">
            <div class="text-right">
                <p class="font-weight-bold mb-0">Print at : {{Helper::dateFormatHumanID(date('Y-m-d'))}}</p>
                <p class="mb-0">#{{$InvoiceGroup->invoice_group_number}}</p>
                <p class="font-italic mb-0">*Denda setiap tanggal {{Helper::getActiveSchoolYear('all')->date_of_fine}} per bulan</p>
            </div>
        </div>
        <div class="col-12 mt-4">
            <table class="table table-responsive-sm table-bordered table-sm border">
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
                        <td style="font-size:1em" colspan="4" align="right"><b>SubTotal</b></td>
                        <td style="font-size:1em">{{Helper::MoneyFormat($total)}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:1em" colspan="4" align="right"><b>Denda</b></td>
                        <td style="font-size:1em">{{Helper::MoneyFormat($fineAmount)}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:1em" colspan="4" align="right"><b>Discount Denda</b></td>
                        <td style="font-size:1em">{{Helper::MoneyFormat($fineDiscount)}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:1em" colspan="4" align="right"><b>Total Akhir</b></td>
                        <td style="font-size:1em">{{Helper::MoneyFormat($finalTotal)}}</td>
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
    <div class="row mt-4 text-right">
        <div class="col-lg-6">
            <!-- <p style="margin-bottom: 15%">Penerima</p>
            <p>_____________</p> -->
        </div>
        <div class="col-lg-6">
            <p style="margin-bottom: 10%">Petugas</p>
            <p>{{backpack_user()->name}}</p>
        </div>
    </div>
  </div>

  

  @include(backpack_view('inc.scripts'))


</body>
</html>
