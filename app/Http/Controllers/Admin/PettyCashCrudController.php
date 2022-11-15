<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PettyCashRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Illuminate\Support\Facades\Route;

/**
 * Class PettyCashCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PettyCashCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
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
        CRUD::setModel(\App\Models\PettyCash::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/petty-cash');
        CRUD::setEntityNameStrings('petty cash', 'petty cashes');

        $this->crud->addButton('top', 'create', 'view', 'crud::buttons.create');
    }

    protected function setupPettyCashCostumRoutes($segment, $routeName, $controller) {

        Route::get($segment.'/PettyCashCostum', [
            'as'        => $routeName.'.PettyCashCostum',
            'uses'      => $controller.'@PettyCashCostum',
            'operation' => 'PettyCashCostum',
        ]);

    }

    public function PettyCashCostum(){
        $this->crud->hasAccessOrFail('list');
        // $this->crud->addButton('top', 'create', 'view', 'crud::buttons.create');
        $this->crud->loadDefaultOperationSettingsFromConfig();
        

        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);

        return view('costum.list-petty-cash', $this->data);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // return view('costum.list-petty-cash');
        // return redirect('/admin');
        $this->crud->setListView('costum.list-petty-cash');

        CRUD::column('petty_cash_code')->priority(3);
        CRUD::column('petty_cash_title')->priority(2)->limit(100);
        // CRUD::column('petty_cash_type');
        CRUD::column('debit')->priority(2)->type('money_format');
        CRUD::column('credit')->priority(2)->type('money_format');
        CRUD::column('description')->priority(3);
        // CRUD::column('student_id');
        // CRUD::column('user_id');
        CRUD::column('trx_date')->priority(2);

        
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
        CRUD::setValidation(PettyCashRequest::class);

        CRUD::field('petty_cash_code')->type('hidden')->default(null);
        CRUD::field('petty_cash_title');
        // CRUD::field('petty_cash_type');
        CRUD::field('debit')->tab('IN')->default(0);
        CRUD::field('credit')->tab('OUT')->default(0);
        CRUD::field('description');
        // CRUD::field('student_id');
        // CRUD::field('user_id');
        CRUD::field('trx_date');

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
