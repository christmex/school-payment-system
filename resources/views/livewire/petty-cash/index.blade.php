<div>
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Report
                </div>
                <div class="card-body">
                    <button class="btn btn-info"><i class="la la-print"></i> Print Report From Filter Date</button>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <label for=""><b>Filter start date</b> @error('filter_start_date') <span class="error">{{ $message }}</span> @enderror</label>
                            <input type="date" wire:model="filter_start_date" id="" class="form-control inline"></div>
                        <div class="col-4">
                            <label for=""><b>Filter snd date</b> @error('filter_end_date') <span class="error">{{ $message }}</span> @enderror</label>
                            <input type="date" wire:model="filter_end_date" id="" class="form-control inline">
                        </div>
                        <div class="col-4">
                            <label for=""><b>Search in filter</b> @error('search') <span class="error">{{ $message }}</span> @enderror</label>
                            <input type="text" wire:model="search" id="" class="form-control inline" placeholder="Ex: Bulan Mei">
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
                    <div class="text-value-sm text-primary">{{$crud->sumCreditAndDebitMoneyFormat($filter_start_date,$filter_end_date,$search)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold small">Income By Filter ({{$filter_start_date}} - {{$filter_end_date}})</div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body p-3 d-flex align-items-center"><i class="la la-cash-register bg-primary p-3 font-2xl mr-3"></i>
                <div>
                    <div class="text-value-sm text-primary">{{$crud->countTrx($filter_start_date,$filter_end_date,$search)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold small">Total transaction ({{$filter_start_date}} - {{$filter_end_date}})</div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <!-- <div class="card-header"><i class="fa fa-align-justify"></i> Detail Invoice</div> -->
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">Petty Cash</h4>
                            <div class="small text-muted">BASIC CHRISTIAN SCHOOL</div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-7 d-none d-md-block" wire:ignore>
                            <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                            <label class="btn btn-outline-secondary">
                                <input id="option1" type="radio" name="filter_debit_credit" wire:click="$set('filter_debit_credit', 'ALL')" autocomplete="off" checked=""> ALL
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input id="option2" type="radio" name="filter_debit_credit" wire:click="$set('filter_debit_credit', 'DEBIT')" autocomplete="off"> DEBIT
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input id="option3" type="radio" name="filter_debit_credit" wire:click="$set('filter_debit_credit', 'CREDIT')" autocomplete="off"> CREDIT
                            </label>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    
                    <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                        <thead>
                        <tr>
                            <th>Petty Cash Title</th>
                            @if($filter_debit_credit == 'ALL' || $filter_debit_credit == 'DEBIT')
                                <th>Debit</th>
                            @endif 
                            @if($filter_debit_credit == 'ALL' || $filter_debit_credit == 'CREDIT')
                                <th>Credit</th>
                            @endif
                            <th>TRX Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($crudLoop as $data)
                                <tr>
                                    <td>
                                        {!! $data->petty_cash_title !!}
                                    </td>
                                    @if($filter_debit_credit == 'ALL' || $filter_debit_credit == 'DEBIT')
                                        <td>
                                            {{$data->debitMoneyFormat}}
                                        </td>
                                    @endif
                                    @if($filter_debit_credit == 'ALL' || $filter_debit_credit == 'CREDIT')
                                        <td>{{$data->creditMoneyFormat}}</td>
                                    @endif
                                    <td>{{$data->trx_date}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                @if($filter_debit_credit == 'ALL' || $filter_debit_credit == 'DEBIT')
                                    <th>{{Helper::MoneyFormat($crud->sumDebit($filter_start_date,$filter_end_date,$search))}}</th>
                                @endif
                                @if($filter_debit_credit == 'ALL' || $filter_debit_credit == 'CREDIT')
                                    <th>{{Helper::MoneyFormat($crud->sumCredit($filter_start_date,$filter_end_date,$search))}}</th>
                                @endif
                                @if($filter_debit_credit == 'ALL')
                                    <th>{{$crud->sumCreditAndDebitMoneyFormat($filter_start_date,$filter_end_date,$search)}}</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
</div>
