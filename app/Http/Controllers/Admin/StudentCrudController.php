<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\SppMaster;
use App\Http\Requests\StudentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
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
        CRUD::setModel(\App\Models\Student::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings('student', 'students');
    }

    // public function store(){
        // $this->crud->getRequest()->request->add(['user_id'=> backpack_user()->id]);
        // dd('SPP'.date('ymd'));
        // dd($this->crud->getRequest()->request->get('student_name'));
        // $response = $this->traitStore();

    //     "student_name" => "kiki"
    // "student_phone_number" => "089"
    // "classroom_id" => "1"
    // "spp_master_id" => "1"
    // "personal_discount" => null
    // "join_month" => "7"
    // "school_year_id" => "1"
    // "_save_action" => "save_and_back"

        // $createPayment = Payment::create([
        //     'payment_invoice' => 'SPP'.date('Ymd').'-',
        //     'student_id' => ,
        //     'spp_master_id' => ,
        //     'school_year_id' => ,
        //     'payment_for_month' => ,
        //     'fine_amount' => ,
        //     'discount_fine' => ,
        //     'total_amount' => ,
        //     'discount_personal' => ,
        //     'paid_amount' => ,
        //     'description' => ,
        //     'payment_way_id' => ,
        //     'user_id' => backpack_user()->id
        // ]);
        // $spp = SppMaster::find($this->data['entry']->spp_master_id);
        // $invoice = Invoice::create([
        //     'payment_invoice' => 'SPP'.date('Ymd').'-',
        //     'student_id' => $this->data['entry']->id,
        //     'cost' => $spp->amount,
        //     'teacher_classroom_id' => $this->data['entry']->teacher_classroom_id,
        //     'school_year_id' => $this->data['entry']->school_year_id,
        //     'payment_for_month' => $this->data['entry']->join_month,
        //     'description' => NULL,
        // ]);

        
        // do something after save
        // return $response;
    // }
    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // dd(Student::with('StudentHistory')->get());
        CRUD::column('student_name');
        CRUD::column('student_phone_number');
        // CRUD::column('classroom_id');
        CRUD::addColumn([
            "label" => "Classroom",
            "entity" => "StudentSchoolHistory.Classroom",
            "model" => "App\Models\StudentSchoolHistory",
            "type" => "select",
            "attribute" => "classroom_name"
        ]);
        CRUD::addColumn([
            "label" => "SPP",
            "entity" => "StudentFundingDetail.SppMaster",
            "model" => "App\Models\StudentFundingDetail",
            "type" => "select",
            "attribute" => "AmountMoneyFormat"
        ]);

        // Bisa pakai ini jga
        // CRUD::addColumn([
        //     'label'  => 'Spp',
        //     'type'  => 'model_function',
        //     'function_name' => 'getStudentFundingDetail',
        //     'limit' => 1000
        // ]);


        // CRUD::addColumn([
        //     "name" => "spp_master_id",
        //     "label" => "SPP",
        //     "entity" => "SppMaster",
        //     "model" => "App\Models\SppMaster",
        //     "type" => "select",
        //     "attribute" => "amount"
        // ]);
        // CRUD::addColumn([
        //     'name' => 'student_history',
        //     'type'  => 'model_function',
        //     'function_name' => 'StudentHistory'
        // ]);
        // CRUD::column('personal_discount')->type('money_format');
        // CRUD::column('personal_discount');
        // CRUD::addColumn([
        //     'name' => 'join_month',
        //     'type'  => 'model_function',
        //     'function_name' => 'getMonthById'
        // ]);
        // CRUD::addColumn([
        //     "name" => "school_year_id",
        //     "label" => "School Year",
        //     "entity" => "SchoolYear",
        //     "model" => "App\Models\SchoolYear",
        //     "type" => "select",
        //     "attribute" => "school_year_name"
        // ]);
        // $this->crud->enableBulkActions();
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
        CRUD::setValidation(StudentRequest::class);

        CRUD::field('student_name');
        CRUD::field('student_phone_number');
        $this->crud->addField([
            'type' => 'select',
            'label' => 'Classroom',
            'name' => 'classroom_id', // the relationship name in your Migration
            'entity' => 'Classroom', // the relationship name in your Model
            'attribute' => 'classroom_name', // attribute that is shown to admin
        ]);
        $this->crud->addField([
            'type' => 'select',
            'name' => 'spp_master_id', // the relationship name in your Migration
            'entity' => 'SppMaster', // the relationship name in your Model
            // 'attribute' => 'amount', // attribute that is shown to admin
            'attribute' => 'AmountMoneyFormat', // attribute that is shown to admin
        ]);
        CRUD::field('personal_discount')->type('number')->attributes(['placeholder' => 0,'min' => 0])->default(0);
        $this->crud->addField([
            // 'type' => 'month',
            'name' => 'join_month', // the relationship name in your Migration
            // 'attributes' => [
            //     'min' => '2022-01',
            //     'max'       => '2022-12',
            //   ], // change the HTML attributes of your input

            'type'        => 'select_from_array',
            'options' => Helper::SchoolYearMonth(),
            'allows_null' => true,
        ]);
        $this->crud->addField([
            'type' => 'select',
            'name' => 'school_year_id', // the relationship name in your Migration
            'entity' => 'Schoolyear', // the relationship name in your Model
            'attribute' => 'school_year_name', // attribute that is shown to admin
            'allows_null'     => false,
            'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->where('is_active',true)->get();
            }), //  you can use this to filter the results show in the select
            // kasih option function filter schol year yg aktif saja, 
            // after insert data siswa baru buat tagihan di bulan mendaftar
            // Gimananya caranya buat tagihan automatis
        ]);

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
        $this->crud->removeField('classroom_id');
        $this->crud->removeField('spp_master_id');
        $this->crud->removeField('personal_discount');
        $this->crud->removeField('school_year_id');
    }

    protected function setupPayInvoiceOperation(){
        // CRUD::field('id');
        CRUD::column('id');
        CRUD::column('invoice_number')->priority(2);
        CRUD::column('amount')->type('money_format');
        // dd($this->crud->getRequest()->request);
    }
}
