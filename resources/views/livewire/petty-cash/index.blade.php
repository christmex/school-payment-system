<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label for=""><b>Start date</b> @error('filter_start_date') <span class="error">{{ $message }}</span> @enderror</label>
                            <input type="date" wire:model="filter_start_date" id="" class="form-control inline"></div>
                        <div class="col-6">
                            <label for=""><b>End date</b> @error('filter_end_date') <span class="error">{{ $message }}</span> @enderror</label>
                            <input type="date" wire:model="filter_end_date" id="" class="form-control inline">
                        </div>
                    </div>
                    <!-- <div class="row mt-3">
                        <div class="col-lg-12">
                            <button class="btn btn-primary btn-block" wire:click="filter">Filter</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body p-3 d-flex align-items-center"><i class="la la-cash-register bg-primary p-3 font-2xl mr-3"></i>
                <div>
                    <div class="text-value-sm text-primary">{{$crud->sumCreditAndDebitMoneyFormat($filter_start_date,$filter_end_date)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold small">Income By Filter ({{$filter_start_date}} - {{$filter_end_date}})</div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body p-3 d-flex align-items-center"><i class="la la-cash-register bg-primary p-3 font-2xl mr-3"></i>
                <div>
                    <div class="text-value-sm text-primary">{{$crud->countTrx($filter_start_date,$filter_end_date)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold small">Total transaction ({{$filter_start_date}} - {{$filter_end_date}})</div>
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
                            @foreach($crud->whereBetween('trx_date',[$filter_start_date, $filter_end_date])->get() as $data)
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
                                <th>{{Helper::MoneyFormat($crud->sumDebit($filter_start_date,$filter_end_date))}}</th>
                                <th>{{Helper::MoneyFormat($crud->sumCredit($filter_start_date,$filter_end_date))}}</th>
                                <th>{{$crud->sumCreditAndDebitMoneyFormat($filter_start_date,$filter_end_date)}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
</div>
