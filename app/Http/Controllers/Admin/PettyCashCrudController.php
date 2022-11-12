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
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $search;
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

        
        // $this->crud->setListView('costum.list-petty-cash');
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
        $this->crud->loadDefaultOperationSettingsFromConfig();
        

        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('costum.list-petty-cash', $this->data);
    }


    // public function search(){
    //     $this->crud->hasAccessOrFail('list');

    //     $this->crud->applyUnappliedFilters();

    //     $start = (int) request()->input('start');
    //     $length = (int) request()->input('length');
    //     $search = request()->input('search');

    //     // if a search term was present
    //     if ($search && $search['value'] ?? false) {
    //         // filter the results accordingly
    //         $this->crud->applySearchTerm($search['value']);
    //     }
    //     // start the results according to the datatables pagination
    //     if ($start) {
    //         $this->crud->skip($start);
    //     }
    //     // limit the number of results according to the datatables pagination
    //     if ($length) {
    //         $this->crud->take($length);
    //     }
    //     // overwrite any order set in the setup() method with the datatables order
    //     $this->crud->applyDatatableOrder();

    //     $entries = $this->crud->getEntries();

    //     // if show entry count is disabled we use the "simplePagination" technique to move between pages.
    //     if ($this->crud->getOperationSetting('showEntryCount')) {
    //         $totalEntryCount = (int) (request()->get('totalEntryCount') ?: $this->crud->getTotalQueryCount());
    //         $filteredEntryCount = $this->crud->getFilteredQueryCount() ?? $totalEntryCount;
    //     } else {
    //         $totalEntryCount = $length;
    //         $filteredEntryCount = $entries->count() < $length ? 0 : $length + $start + 1;
    //     }

    //     // store the totalEntryCount in CrudPanel so that multiple blade files can access it
    //     $this->crud->setOperationSetting('totalEntryCount', $totalEntryCount);
    //     $beforeReturn = $this->crud->getEntriesAsJsonForDatatables($entries, $totalEntryCount, $filteredEntryCount, $start);
    //     $beforeReturn['searchQuery'] = $search['value'];
    //     // $this->search = $search['value'];
    //     return $beforeReturn;
    // }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
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
