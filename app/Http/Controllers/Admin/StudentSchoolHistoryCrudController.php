<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentSchoolHistoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StudentSchoolHistoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentSchoolHistoryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\StudentSchoolHistory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student-school-history');
        CRUD::setEntityNameStrings('student school history', 'student school histories');
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
        CRUD::addColumn([
            "name" => "classroom_id",
            "label" => "Classroom",
            "entity" => "Classroom",
            "model" => "App\Models\Classroom",
            "type" => "select",
            "attribute" => "classroom_name"
        ]);
        CRUD::column('desc');
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
        CRUD::setValidation(StudentSchoolHistoryRequest::class);

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
            'name' => 'classroom_id', // the relationship name in your Migration
            'entity' => 'Classroom', // the relationship name in your Model
            'attribute' => 'classroom_name', // attribute that is shown to admin
        ]);
        CRUD::field('desc');

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
