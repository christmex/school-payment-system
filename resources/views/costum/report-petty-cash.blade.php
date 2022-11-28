<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
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
                <p class="mb-0">#PETTYCASH-REPORT</p>
            </div>
        </div>
        <div class="col-12 mt-4">
            <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>TITLE | REPORT DATE {{$currentDate}}</th>
                        <th>PAYMENT WAY</th>
                        <th>SCHOOL LEVEL</th>
                        <th>DEBIT</th>
                   </tr>
                </thead>
                <tbody>
                    @php 
                        $sumDebit = 0;
                        $linePaymentWay = NULL;
                        $subTotal = 0;
                    @endphp 
                    @foreach($PettyCash as $data)

                        @if($linePaymentWay == NULL)
                            @php 
                                $linePaymentWay = $data->payment_way;
                            @endphp 
                        @endif

                        @if($linePaymentWay != $data->payment_way)
                            <tr>
                                <td colspan=3>Subtotal</td>
                                <td>{{Helper::MoneyFormat($subTotal)}}</td>
                                @php 
                                    $subTotal = 0;
                                    $subTotal += $data->debit;
                                    $linePaymentWay = $data->payment_way;
                                @endphp 
                            </tr>
                        @else 
                            @php 
                                $subTotal += $data->debit;
                            @endphp 
                        @endif 
                        <tr>
                            <td>{!! $data->petty_cash_title !!}</td>
                            <td>{{$data->payment_way}}</td>
                            <td>{{$data->school_level}}</td>
                            <td>{{Helper::MoneyFormat($data->debit)}}</td>
                        </tr>

                        @if($loop->last)
                        <tr>
                                <td colspan=3>Subtotal</td>
                                <td>{{Helper::MoneyFormat($subTotal)}}</td>
                            </tr>
                        @endif

                        @php $sumDebit+=$data->debit; @endphp 
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan=3>TOTAL KESELURUHAN</th>
                        <th>{{Helper::MoneyFormat($sumDebit)}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        
    </div>
  </div>

  

  @include(backpack_view('inc.scripts'))


</body>
</html>
