<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentFundingDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StudentFundingDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentFundingDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\StudentFundingDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student-funding-detail');
        CRUD::setEntityNameStrings('student funding detail', 'student funding details');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('student_id');
        CRUD::addColumn([
            "name" => "school_year_id",
            "label" => "School Year",
            "entity" => "SchoolYear",
            "model" => "App\Models\SchoolYear",
            "type" => "select",
            "attribute" => "school_year_name"
        ]);
        // CRUD::addColumn([
        //     'name' => 'spp_master_id',
        //     'type'  => 'model_function',
        //     'function_name' => 'SppMasterGet'
        // ]);
        CRUD::addColumn([
            "name" => "spp_master_id",
            "label" => "SPP",
            "entity" => "SppMaster",
            "model" => "App\Models\SppMaster",
            "type" => "select",
            "attribute" => "AmountMoneyFormat"
        ]);
        CRUD::column('personal_discount')->type('money_format');
        $this->crud->removeButton('delete');
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(StudentFundingDetailRequest::class);

        CRUD::field('student_id');
        $this->crud->addField([
            'type' => 'select',
            'name' => 'school_year_id', // the relationship name in your Migration
            'entity' => 'Schoolyear', // the relationship name in your Model
            'attribute' => 'school_year_name', // attribute that is shown to admin
            // kasih option function filter schol year yg aktif saja, 
            // after insert data siswa baru buat tagihan di bulan mendaftar
            // Gimananya caranya buat tagihan automatis
        ]);
        $this->crud->addField([
            'type' => 'select',
            'name' => 'spp_master_id', // the relationship name in your Migration
            'entity' => 'SppMaster', // the relationship name in your Model
            'attribute' => 'amount', // attribute that is shown to admin
        ]);
        CRUD::field('personal_discount')->type('number')->attributes(['placeholder' => 0,'min' => 0])->default(0);
        CRUD::field('additional')->type('number')->attributes(['placeholder' => 0,'min' => 0])->default(0);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
