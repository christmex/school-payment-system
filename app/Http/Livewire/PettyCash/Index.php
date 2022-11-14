<?php

namespace App\Http\Livewire\PettyCash;

use Livewire\Component;

class Index extends Component
{

    public $crud;
    public $filter_start_date;
    public $filter_end_date;
    public $search;
    
    protected $rules = [
        'filter_start_date' => 'date|before_or_equal:filter_end_date',
        'filter_end_date' => 'after_or_equal:filter_start_date',
    ];

    public function mount($crud){
        $this->crud = $crud->model;
        $this->filter_start_date = $this->filter_end_date = date('Y-m-d');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    

    public function render()
    {
        return view('livewire.petty-cash.index');
    }

    public function filter(){
        $validatedData = $this->validate();
    }


}
