@extends(backpack_view('blank'))

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">Generate Petty Cash Report</span>
	  </h2>
	</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Report
                </div>
                <div class="card-body">
                    <form action="{{ backpack_url('report/petty-cash/print') }}" method="post" target="_blank">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="date" name="date" class="form-control mb-3" required>
                        <button type="submit" class="btn btn-info"><i class="la la-print"></i> Print Report From Date</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

