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

    use \App\Http\Controllers\Admin\Operations\PayInvoiceOperation;

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
        // Set this for filter this month
        // dd(Helper::getCurrentMonth());
        // dd($);
        // $this->crud->addClause('where', 'payment_for_month', '<=', Helper::getCurrentMonth());
        // $this->crud->addClause('where', 'school_year_id', '=', Helper::getActiveSchoolYear());
        $this->crud->addClause('where', 'paid_date', '=', NULL);
        // Set this for reorder the id
        $this->crud->orderBy('id','asc');

        $this->crud->addColumn([
            'name'      => 'row_number',
            'type'      => 'row_number',
            'label'     => '#',
            'orderable' => false,
        ])->makeFirstColumn();

        CRUD::column('invoice_number');
        CRUD::addColumn([
            "name" => "student_id",
            "label" => "Student Name",
            "entity" => "Student",
            "model" => "App\Models\Student",
            "type" => "select",
            "attribute" => "student_name",
            "priority" => 2
        ]);
        CRUD::addColumn([
            'type' => 'select',
            'label' => 'Classroom',
            'name' => 'classroom_id', // the relationship name in your Migration
            'entity' => 'Classroom', // the relationship name in your Model
            'attribute' => 'classroom_name', // attribute that is shown to admin
            "priority" => 2
        ]);
        // $this->crud->column('amount')->type('number')->prefix('');
        CRUD::addColumn([
            'type' => 'money_format',
            'label' => 'Amounts',
            'name' => 'amount', 
            // 'wrapper' => [
            //     'element' => 'span',
            //     'class' => 'badge badge-danger'
            // ],
            "priority" => 2
        ]);
        // CRUD::addColumn([
        //     'type' => 'money_format',
        //     // 'label' => 'Per',
        //     'name' => 'personal_discount', 
        //     // 'wrapper' => [
        //     //     'element' => 'span',
        //     //     'class' => 'badge badge-success'
        //     // ],
        //     "priority" => 2
        // ]);
        $this->crud->column('personal_discount')->type('money_format');
        // CRUD::addColumn([
        //     'name'     => 'personal_discount',
        //     'label'    => 'Personal Discount',
        //     'type'     => 'custom_html',
        //     'value'    => function($entry) {
        //         return "<input type='number' value='{$entry->personal_discount}' min='0' name='personal_discount[]'>";
                
        //     } 
        // ]);
        CRUD::column('fine_amount')->type('money_format');
        CRUD::column('fine_discount')->type('money_format');
        // CRUD::addColumn([
        //     'name'     => 'fine_discount',
        //     'label'    => 'Fine Discount',
        //     'type'     => 'custom_html',
        //     'value'    => function($entry) {
        //         return "<input type='number' value='{$entry->fine_discount}' min='0' name='fine_discount[]'>";
                
        //     } 
        // ]);

        // CRUD::column('fine_amount')->type('money_format');
        // CRUD::addColumn([
        //     "name" => "classroom_id",
        //     "label" => "Classroom",
        //     "entity" => "Student.hehe.Classroom",
        //     "model" => "App\Models\Student",
        //     "type" => "select",
        //     "attribute" => "teacher_id"
        // ]);
        CRUD::addColumn([
            'name' => 'payment_for_month',
            'type'  => 'model_function',
            "priority" => 1,
            'function_name' => 'getMonthById'
        ]);
        CRUD::column('due_date')->priority(2);
        CRUD::addColumn([
            "name" => "school_year_id",
            "label" => "School Year",
            "entity" => "SchoolYear",
            "model" => "App\Models\SchoolYear",
            "type" => "select",
            "attribute" => "school_year_name"
        ]);
        CRUD::addColumn([
            'name'     => 'total',
            'label'    => 'Total Amount',
            'type'     => 'custom_html',
            'value'    => function($entry) {
                $total = $entry->amount + $entry->fine_amount;
                return "<span>".Helper::MoneyFormat($total)."</span>";

                // $total = Helper::moneyFormat($entry->amount + $entry->fine_amount);
                // return "<input type='text' value='{$total}' name='total[]'>";
                
            } 
        ]);
        CRUD::addColumn([
            "name" => "created_by",
            "label" => "Created By",
            "entity" => "createdBy",
            "model" => "App\Models\Invoice",
            "type" => "select",
            "attribute" => "name"
        ]);
        CRUD::addColumn([
            "name" => "updated_by",
            "label" => "Updated By",
            "entity" => "updatedBy",
            "model" => "App\Models\Invoice",
            "type" => "select",
            "attribute" => "name"
        ]);
        
        

        // CRUD::addColumn([
        //     'name' => 'payment_for_month',
        //     'type'  => 'model_function',
        //     'function_name' => 'getMonthById'
        // ]);
        // CRUD::column('description');
        // $this->crud->removeAllButtonsFromStack('line');
        $this->crud->enableBulkActions();
        $this->crud->removeAllButtons();
        $this->crud->addButtonFromView('bottom', 'pay_invoice', 'pay-invoice', 'beginning');
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

        CRUD::field('invoice_number');
        CRUD::field('student_id');
        $this->crud->addField([
            'type' => 'select',
            'name' => 'cost', // the relationship name in your Migration
            'entity' => 'SppMaster', // the relationship name in your Model
            'attribute' => 'amount', // attribute that is shown to admin
            'allows_null' => true,
        ]);
        CRUD::field('costum_cost')->type('number')->attributes(['min' => 0]);
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

    protected function setupPayInvoiceOperation(){
        CRUD::field('student_id');
        // dd($this->crud->getRequest()->request);
    }

}
