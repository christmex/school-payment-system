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
            @foreach($entry as $data)
                <tr>
                    <td>{{$data->student->student_name}}</td>
                    <td>{{$data->PaymentForMonthInHumanWay}}</td>
                    <td>{{$data->AmountMoneyFormat}}</td>
                    <td>{{$data->PersonalDiscountMoneyFormat}}</td>
                    <td><span class="badge badge-success">Active</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn btn-primary">asd</button>
        </div>
    </div>
    </div>
    <!-- /.col-->
</div>
@endsection