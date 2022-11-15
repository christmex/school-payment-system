<?php

namespace App\Http\Livewire\PettyCash;

use Livewire\Component;

class Index extends Component
{

    public $crud;
    public $crudLoop;
    public $filter_start_date;
    public $filter_end_date;
    public $search;
    public $filter_in_out;
    public $query;
    
    protected $rules = [
        'filter_start_date' => 'date|before_or_equal:filter_end_date',
        'filter_end_date' => 'after_or_equal:filter_start_date',
    ];

    public function mount($crud){
        $this->crud = $crud->model;
        $this->filter_start_date = $this->filter_end_date = date('Y-m-d');
        $this->filter_debit_credit = 'ALL';

        $this->crudLoop = $crud->model->whereBetween('trx_date',[$this->filter_start_date, $this->filter_end_date])->where('petty_cash_title', 'like', '%'.$this->search.'%')->get();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if($this->filter_debit_credit == 'ALL'){
            $this->crudLoop = $this->crud->whereBetween('trx_date',[$this->filter_start_date, $this->filter_end_date])->where('petty_cash_title', 'like', '%'.$this->search.'%')->get();
        }
        if($this->filter_debit_credit == 'DEBIT'){
            $this->crudLoop = $this->crud->whereBetween('trx_date',[$this->filter_start_date, $this->filter_end_date])->where('petty_cash_title', 'like', '%'.$this->search.'%')->where('debit','!=',0)->get();
        }
        if($this->filter_debit_credit == 'CREDIT'){
            $this->crudLoop = $this->crud->whereBetween('trx_date',[$this->filter_start_date, $this->filter_end_date])->where('petty_cash_title', 'like', '%'.$this->search.'%')->where('credit','!=',0)->get();
        }
    }
    

    public function render()
    {
        return view('livewire.petty-cash.index');
    }

    public function filter(){
        $validatedData = $this->validate();
    }


}
