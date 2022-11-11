@extends(backpack_view('blank'))
@once
  @push('befor_styles')
  <livewire:styles/>
  @endpush
@endonce


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
            <livewire:pay-invoice :entry="$entry"/> 
        </div>
    </div>
    </div>
    <!-- /.col-->
</div>
@endsection

@once
  @push('after_scripts')
    <livewire:scripts/>
  @endpush
@endonce