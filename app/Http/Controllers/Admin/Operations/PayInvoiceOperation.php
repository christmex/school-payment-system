<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait PayInvoiceOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupPayInvoiceRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/pay-invoice', [
            'as'        => $routeName.'.payInvoice',
            'uses'      => $controller.'@payInvoice',
            'operation' => 'payInvoice',
        ]);

        Route::post($segment.'/{id}/pay-invoice', [
            'as'        => $routeName.'.doPayInvoice',
            'uses'      => $controller.'@doPayInvoice',
            'operation' => 'payInvoice',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupPayInvoiceDefaults()
    {
        CRUD::allowAccess('payInvoice');

        CRUD::operation('payInvoice', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();

            $this->crud->setupDefaultSaveActions();
        });

        CRUD::operation('list', function () {
            // $this->crud->addButton('line', 'payInvoice', 'view', 'crud::buttons.pay-invoice','beginning');
            // CRUD::addButton('top', 'pay_invoice', 'view', 'crud::buttons.pay_invoice');
            CRUD::addButton('line', 'pay_invoice', 'view', 'crud::buttons.pay_invoice','beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function payInvoice($id)
    {
        CRUD::hasAccessOrFail('payInvoice');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;
        // get the info for that entry

        $this->data['entry'] = $this->crud->getEntryWithLocale($id);
        $this->crud->setOperationSetting('fields', $this->crud->getUpdateFields());

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::program_costum.pay').' '.$this->crud->entity_name;
        $this->data['id'] = $id;

        // load the view
        return view('crud::operations.pay_invoice', $this->data);
    }

    public function doPayInvoice(){
        
    }
}