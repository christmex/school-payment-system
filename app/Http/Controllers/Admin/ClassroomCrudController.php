<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClassroomRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClassroomCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClassroomCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Classroom::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/classroom');
        CRUD::setEntityNameStrings('classroom', 'classrooms');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('school_level_id');
        CRUD::addColumn([
            "name" => "school_level_id",
            "label" => "School Level",
            "entity" => "SchoolLevel",
            "model" => "App\Models\SchoolLevel",
            "type" => "select",
            "attribute" => "school_level"
        ]);
        CRUD::column('classroom_name');
        CRUD::column('teacher_id');
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
        CRUD::setValidation(ClassroomRequest::class);

        $this->crud->addField([
            'type' => 'select',
            'name' => 'school_level_id', // the relationship name in your Migration
            'entity' => 'SchoolLevel', // the relationship name in your Model
            'attribute' => 'school_level', // attribute that is shown to admin
        ]);
        CRUD::field('classroom_name');
        // CRUD::field('teacher_id');
        $this->crud->addField([
            'type' => 'select',
            'name' => 'teacher_id', // the relationship name in your Migration
            'entity' => 'Teacher', // the relationship name in your Model
            'attribute' => 'teacher_name', // attribute that is shown to admin
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
    }
}
