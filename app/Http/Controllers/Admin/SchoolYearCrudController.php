<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\SchoolYearRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SchoolYearCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SchoolYearCrudController extends CrudController
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
        CRUD::setModel(\App\Models\SchoolYear::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/school-year');
        CRUD::setEntityNameStrings('school year', 'school years');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('school_year_name')->wrapper([
        //     'element' => 'span',
        //     'class' => function ($crud, $column, $entry, $related_key) {
        //         if ($entry->is_active == 1) {
        //             return 'badge badge-success';
        //         }
        //     }
        // ]);
        CRUD::addColumn([
            'name'     => 'school_year_name',
            'type'     => 'custom_html',
            // 'value'    => $entry->id,
            'value'    => function ($entry){
                            
                            if ($entry->is_active == 1) {
                                return $entry->school_year_name.' <span class="badge badge-success">Active</span>';
                            }else  {
                                return $entry->school_year_name;
                            }
            },        
        ]);
        CRUD::column('school_year_start');
        CRUD::column('school_year_end');
        CRUD::column('date_of_fine');
        CRUD::column('fine_amount');
        CRUD::column('is_active'); //jadikan switch buat tombol or kolom baru entalah
        $this->crud->removeButton('delete');
        $this->crud->addButtonFromView('line', 'activate', 'change-school-year', 'beginning');
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
        CRUD::setValidation(SchoolYearRequest::class);

        // CRUD::field('school_year_name')->prefix('School Year')->type('hidden')->default(null);
        // CRUD::field('school_year_name')->prefix('School Year');
        CRUD::field('school_year_start');
        CRUD::field('school_year_end');
        CRUD::field('date_of_fine')->type('number');
        CRUD::field('fine_amount')->default(0);
        // CRUD::field('is_active')->type('hidden');

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

    public function activate(){
        $id = $this->crud->getRequest()->input('id');
        $getModel = $this->crud->model->find($id);
        // if($getModel->school_year_start > 2023 && $getModel->school_year_start < 2023 + 1){
            // if($getModel->school_year_start >= date('Y') && $getModel->school_year_start <= date('Y') + 1){
        if($getModel->school_year_start == date('Y')){
            DB::table('school_years')->update(['is_active' => 0]);
            $getModel->is_active = 1;
            $getModel->save();
            return response("Berhasil mengaktifkan tahun ajaran {$getModel->school_year_name}.", 200);
        }else {
            return response('Silahkan mengaktifkan tahun ajaran ini di tahun depan', 403);
            
        }
    }
}
