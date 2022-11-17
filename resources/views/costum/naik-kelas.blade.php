@extends(backpack_view('blank'))
@once
  @push('befor_styles')
  <livewire:styles/>
  @endpush
@endonce

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">Naik Kelas</span>
	  </h2>
	</section>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i> Form Kenaikan Kelas</div>
        <div class="card-body">
            <livewire:naik-kelas/> 
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

