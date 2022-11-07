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
        Route::get($segment.'/{id}/list-invoice', [
            'as'        => $routeName.'.listInvoice',
            'uses'      => $controller.'@listInvoice',
            'operation' => 'payInvoice',
        ]);

        Route::post($segment.'/{id}/pay-invoice', [
            'as'        => $routeName.'.PayInvoice',
            'uses'      => $controller.'@PayInvoice',
            'operation' => 'payInvoice',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupPayInvoiceDefaults()
    {
        CRUD::allowAccess('listInvoice');

        CRUD::operation('payInvoice', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
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
    public function listInvoice($id)
    {
        CRUD::hasAccessOrFail('listInvoice');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;
        // get the info for that entry

        // $this->data['entry'] = $this->crud->with('invoices')->findOrFail($id)->invoices;
        $this->data['entry'] = $this->crud->getEntryWithLocale($id);
        // $this->crud->setOperationSetting('fields', $this->crud->getUpdateFields());

        $this->data['crud'] = $this->crud;
        // $this->data['saveAction'] = $this->crud->getSaveAction();
        // $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::program_costum.pay').' '.$this->crud->entity_name;
        $this->data['id'] = $id;
        // dd($this->crud->getEntries());
        // dd($this->crud->with('invoices')->getEntries($id));
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);
        // load the view
        // dd($this->data['entry']);
        return view('crud::operations.pay_invoice', $this->data);
    }


    public function PayInvoice(){
        
    }
}