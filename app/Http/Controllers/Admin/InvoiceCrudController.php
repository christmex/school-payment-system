<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Requests\InvoiceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InvoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvoiceCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Invoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invoice');
        CRUD::setEntityNameStrings('invoice', 'invoices');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('payment_invoice');
        CRUD::addColumn([
            "name" => "student_id",
            "label" => "Student Name",
            "entity" => "Student",
            "model" => "App\Models\Student",
            "type" => "select",
            "attribute" => "student_name"
        ]);
        CRUD::column('cost')->type('money_format');
        CRUD::addColumn([
            "name" => "teacher_classroom_id",
            "label" => "Classroom",
            "entity" => "TeacherClassroom.Classroom",
            "model" => "App\Models\TeacherClassroom",
            "type" => "select",
            "attribute" => "classroom_name"
        ]);
        CRUD::addColumn([
            "name" => "school_year_id",
            "label" => "School Year",
            "entity" => "SchoolYear",
            "model" => "App\Models\SchoolYear",
            "type" => "select",
            "attribute" => "school_year_name"
        ]);
        // CRUD::column('payment_for_month');
        CRUD::addColumn([
            'name' => 'payment_for_month',
            'type'  => 'model_function',
            'function_name' => 'getMonthById'
        ]);
        CRUD::column('description');
        // $this->crud->removeAllButtonsFromStack('line');
        $this->crud->removeAllButtons();
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
        CRUD::setValidation(InvoiceRequest::class);

        // CRUD::field('payment_invoice');
        CRUD::field('student_id');
        $this->crud->addField([
            'type' => 'select',
            'name' => 'cost', // the relationship name in your Migration
            'entity' => 'SppMaster', // the relationship name in your Model
            'attribute' => 'amount', // attribute that is shown to admin
        ]);
        $this->crud->addField([
            'type' => 'select',
            'name' => 'teacher_classroom_id', // the relationship name in your Migration
            'entity' => 'TeacherClassroom.Classroom', // the relationship name in your Model
            'attribute' => 'classroom_name', // attribute that is shown to admin
        ]);
        $this->crud->addField([
            'type' => 'select',
            'name' => 'school_year_id', // the relationship name in your Migration
            'entity' => 'Schoolyear', // the relationship name in your Model
            'attribute' => 'school_year_name', // attribute that is shown to admin
            // kasih option function filter schol year yg aktif saja, 
            // after insert data siswa baru buat tagihan di bulan mendaftar
            // Gimananya caranya buat tagihan automatis
        ]);
        CRUD::field('payment_for_month');
        $this->crud->addField([
            'name' => 'payment_for_month',
            'type'        => 'select_from_array',
            'options' => Helper::Months(),
            'allows_null' => true,
        ]);
        CRUD::field('description');

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
