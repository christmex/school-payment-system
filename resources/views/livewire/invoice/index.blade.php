<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="filter">
                    <div class="row">
                        <div class="col-12">
                            <label for="students"><b>Nama Siswa</b></label>
                            <input type="text" id="student" wire:model="studentForm" class="form-control inline @error('studentForm')is-invalid @enderror" placeholder="Contoh: John Week" autocomplete="off">
                            @error('studentForm') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror

                            <div class="mt-3">
                                @if($ListTheStudents)
                                    <span>Mungkin maksud anda :</span>
                                    @foreach($ListTheStudents as $data)
                                        @if($loop->last)
                                        <a href="javascript:;" wire:click="SetstudentForm('{{$data->student_name}}')" class="text-underline-hover">{{$data->student_name}}</a>
                                        @else
                                        <a href="javascript:;" wire:click="SetstudentForm('{{$data->student_name}}')" class="text-underline-hover">{{$data->student_name}},</a>
                                        @endif
                                    @endforeach
                                @endif 
                            </div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary btn-block" wire:click="filter">Filter</button>
                        </div>
                    </div>
                    </form>
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
                            <h4 class="card-title mb-0">Invoice</h4>
                            <div class="small text-muted">BASIC CHRISTIAN SCHOOL</div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-7 d-none d-md-block" wire:ignore>
                            <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                            <label class="btn btn-outline-secondary">
                                <input id="option1" type="radio" wire:click="FilterMonth('THIS MONTH')" autocomplete="off" checked=""> THIS MONTH
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input id="option3" type="radio" wire:click="FilterMonth('PAID')" autocomplete="off"> PAID
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input id="option3" type="radio" wire:click="FilterMonth('UNPAID')" autocomplete="off"> UNPAID
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input id="option2" type="radio" wire:click="FilterMonth('ALL')" autocomplete="off"> ALL
                            </label>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    
                    <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                        <thead>
                        <tr>
                            <th>#{{count($Checkbox_MonthId)}}</th>
                            <th>Student Name</th>
                            <th>Month</th>
                            <th>Print</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($studentInvoiceModel))
                                @if($studentInvoiceModel && (count($studentInvoiceModel)))
                                    @foreach($studentInvoiceModel as $data)
                                        <tr>
                                            <td>
                                            @if($data->paid_date == NULL)    
                                                <input type="checkbox" wire:model="Checkbox_MonthId" value="{{$data->id}}"> {{$loop->iteration}}
                                            @endif 
                                            </td>
                                            <td>{{$studentForm}}</td>
                                            <td>
                                                {{$data->getNormalMonth()}} |
                                                TA {{$data->SchoolYear->school_year_name}}
                                                @if($data->paid_date != NULL)
                                                    <span class="badge badge-success">PAID</span>
                                                @else 
                                                    <span class="badge badge-danger">UNPAID</span>
                                                @endif 
                                                
                                            </td>
                                            <td>
                                                @if($data->paid_date != NULL)    <a href="{{backpack_url('report/invoice/'.$data->invoice_group_id)}}" class="btn btn-success btn-small" target="_blank"><i class="la la-print"></i> Print</a> @endif 
                                            </td>
                                        </tr>
                                    @endforeach
                                @else 
                                    <tr>
                                        <td colspan=4 align="center">NO DATA</td>
                                    </tr>
                                @endif
                            @else 
                            <tr>
                                <td colspan=4 align="center">NO DATA</td>
                            </tr>
                            @endif
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#{{count($Checkbox_MonthId)}}</th>
                                <th>Student Name</th>
                                <th>Month</th>
                                <th>Print</th>
                            </tr>
                        </tfoot>
                    </table>
                    @if(!empty($studentInvoiceModel))
                    @if($studentInvoiceModel && (count($studentInvoiceModel)) && count($this->Checkbox_MonthId))
                    <button class="btn btn-success" wire:click="pay">Review Invoice</button>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
</div>
