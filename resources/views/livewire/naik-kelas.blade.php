<div>
    <div class="row">
            <div class="col-lg-6">
                <div class="form-group required">
                    <label for="Form_SchoolYear">Active School Year</label>
                    <input type="text" class="form-control" id="Form_SchoolYear" wire:model="Form_SchoolYear" readonly>
                </div>

                <div class="form-group required">
                    <label for="Form_NewSchoolYear">New School Year</label>
                    <input type="text" class="form-control" id="Form_NewSchoolYear" wire:model="Form_NewSchoolYear" readonly>
                </div>

                <div class="form-group required">
                    <label for="Form_PreviousClassroom">Previous Classroom</label>
                    <select wire:model="Form_PreviousClassroom" id="Form_PreviousClassroom" class="form-control  @error('Form_PreviousClassroom') form-control is-invalid @enderror">
                        <option value="">-</option>
                        @foreach($ClassroomModel as $data)
                            <option value="{{$data->id}}">{{$data->classroom_name}}</option>
                        @endforeach
                    </select>
                    @error('Form_PreviousClassroom') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>#{{count($Checkbox_StudenId)}}</th>
                            <!-- <th>Selected </th> -->
                            <th>Student Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($StudentModel)
                            @foreach($StudentModel as $data)
                            <tr>
                                <td><input type="checkbox" wire:model="Checkbox_StudenId" value="{{$data->student->id}}"> {{$loop->iteration}}</td>
                                <!-- <td></td> -->
                                <td>{{$data->student->student_name}}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6"> <!-- uncomment this if you want to use 2 column and set the col-lg-12 to col-lg-6  -->
                <div class="form-group required">
                    <label for="Form_AfterClassroom">After Classroom</label>
                    <select wire:model="Form_AfterClassroom" id="Form_AfterClassroom" class="form-control @error('Form_AfterClassroom') form-control is-invalid @enderror">
                        <option value="">-</option>
                        @foreach($ClassroomModel as $data)
                            <option value="{{$data->id}}">{{$data->classroom_name}}</option>
                        @endforeach
                    </select>
                    @error('Form_AfterClassroom') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group required">
                    <label for="Form_SppMaster">SPP</label>
                    <select wire:model="Form_SppMaster" id="Form_SppMaster" class="form-control @error('Form_SppMaster') form-control is-invalid @enderror">
                        <option value="">-</option>
                        @foreach($SppMasterModel as $data)
                            <option value="{{$data->id}}">{{$data->AmountMoneyFormat}}</option>
                        @endforeach
                    </select>
                    @error('Form_SppMaster') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group required">
                    <label for="Form_Teacher">Teacher (<i>Select if the teacher changed in that class</i>)</label>
                    <select wire:model="Form_Teacher" id="Form_Teacher" class="form-control">
                        <option value="">-</option>
                        @foreach($TeacherModel as $data)
                            <option value="{{$data->id}}">{{$data->teacher_name}}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-block btn-primary" wire:click="save()">Save</button>
                <span class="mt-2 d-block">(<i>*Saat tombol ini di klik maka siswa yang naik kelas akan otomatis dibuatkan tagihan selama 1 tahun ajaran<i>)</span>
                
            </div>
    </div>
</div>
