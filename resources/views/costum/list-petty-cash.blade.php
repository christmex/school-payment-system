@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
  <div class="container-fluid">
    <h2>
      <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
    </h2>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label for="">Start date</label>
                        <input type="date" name="" id="" class="form-control inline"></div>
                    <div class="col-6">
                        <label for="">End date</label>
                        <input type="date" name="" id="" class="form-control inline">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center"><i class="la la-cash-register bg-primary p-3 font-2xl mr-3"></i>
            <div>
                <div class="text-value-sm text-primary">{{$crud->model->sumCreditAndDebitMoneyFormat()}}</div>
                <div class="text-muted text-uppercase font-weight-bold small">Today Income ({{date('Y-m-d')}})</div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center"><i class="la la-cash-register bg-primary p-3 font-2xl mr-3"></i>
            <div>
                <div class="text-value-sm text-primary">0</div>
                <div class="text-muted text-uppercase font-weight-bold small">Income By Filter</div>
            </div>
            </div>
        </div>
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
                        <th>Petty Cash Title</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>TRX Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php 
                            $datenow = date('Y-m-d');
                        @endphp
                        @foreach($crud->model->where('trx_date',$datenow)->get() as $data)
                            <tr>
                                <td>
                                    {{$data->petty_cash_title}}
                                </td>
                                <td>
                                    {{$data->debitMoneyFormat}}
                                </td>
                                <td>{{$data->creditMoneyFormat}}</td>
                                <td>{{$data->trx_date}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>{{Helper::MoneyFormat($crud->model->sumDebit($datenow))}}</th>
                            <th>{{Helper::MoneyFormat($crud->model->sumCredit($datenow))}}</th>
                            <th>{{$crud->model->sumCreditAndDebitMoneyFormat($datenow)}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        </div>
        <!-- /.col-->
    </div>

@endsection
