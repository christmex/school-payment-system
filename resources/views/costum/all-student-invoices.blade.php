@extends(backpack_view('blank'))
@once
  @push('befor_styles')
  <livewire:styles/>
  @endpush
@endonce

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">Invoices</span>
	  </h2>
	</section>
@endsection

@section('content')
    <livewire:invoice.index/> 
@endsection


@once
  @push('after_scripts')
    <livewire:scripts/>
  @endpush
@endonce

