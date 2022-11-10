@extends(backpack_view('blank'))

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::program_costum.pay').' '.$crud->entity_name !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="{{ $crud->getEditContentClass() }}">
		{{-- Default box --}}

		@include('crud::inc.grouped_errors')



          
        </form>

	</div>
</div>

<div class="row">
    <div class="col-lg-12">
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i> Detail Invoice</div>
        <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
            <thead>
            <tr>
                <th>Student Data</th>
                <th>Payment For Month</th>
                <th>Amount</th>
                <th>Personal Discount</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $fineAmount = 0;
                @endphp 
            @foreach($entry as $data)
                <tr>
                    <td>{{$data->student->student_name}}</td>
                    <td>{{$data->PaymentForMonthInHumanWay}}</td>
                    <td>{{$data->AmountMoneyFormat}}</td>
                    <td>RP. <input type='number' value='{{$data->personal_discount}}' min='0' name='personal_discount[]' style="border:none"></td>
                    
                    <td>{{$data->SubTotalMoneyFormat}}</td>
                    @php 
                        $total += $data->SubTotal;
                        $fineAmount = $data->fine_amount >= $fineAmount ? $data->fine_amount : $fineAmount;
                    @endphp 
                    <!-- <td><span class="badge badge-success">as</span></td> -->
                </tr>
            @endforeach
                @php 
                    $finalTotal = Helper::MoneyFormat($total + ($fineAmount));
                @endphp 
                <tr>
                    <td colspan="4" align="right"><b>Total</b></td>
                    <td>{{ Helper::MoneyFormat($total) }}</td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><b>Fine Amount</b></td>
                    <td>{{ Helper::MoneyFormat($fineAmount) }}</td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><b>Fine Discount</b></td>
                    <td>RP. <input type="number" min="0" style="border:none"></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><b>Final Total</b></td>
                    <td>{{$finalTotal}}</td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-primary">asd</button>
        </div>
    </div>
    </div>
    <!-- /.col-->
</div>
@endsection