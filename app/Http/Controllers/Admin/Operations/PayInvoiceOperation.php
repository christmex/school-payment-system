<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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
        Route::get($segment.'/list-invoice', [
            'as'        => $routeName.'.listInvoice',
            'uses'      => $controller.'@listInvoice',
            'operation' => 'payInvoice',
        ]);

        Route::post($segment.'/pay-invoice', [
            'as'        => $routeName.'.PayInvoice',
            'uses'      => $controller.'@PayInvoice',
            'operation' => 'payInvoice',
        ]);

        Route::get($segment.'/{id}/preview-invoice', [
            'as'        => $routeName.'.PreviewInvoice',
            'uses'      => $controller.'@PreviewInvoice',
            'operation' => 'payInvoice',
        ]);

        
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupPayInvoiceDefaults()
    {
        CRUD::allowAccess('listInvoice');

        $this->crud->operation('list', function () {
            $this->crud->enableBulkActions();
            $this->crud->addButton('bottom', 'pay_invoice', 'view', 'crud::buttons.pay_invoice', 'beginning');
        });

        // CRUD::operation('payInvoice', function () {
        //     CRUD::loadDefaultOperationSettingsFromConfig();
        // });

        // CRUD::operation('list', function () {
        //     // $this->crud->addButton('line', 'payInvoice', 'view', 'crud::buttons.pay-invoice','beginning');
        //     // CRUD::addButton('top', 'pay_invoice', 'view', 'crud::buttons.pay_invoice');
        //     CRUD::addButton('line', 'pay_invoice', 'view', 'crud::buttons.pay_invoice','beginning');
        // });
        
    }


    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function listInvoice()
    {
        CRUD::hasAccessOrFail('listInvoice');
        dd($this->data['entries']);

        // // get entry ID from Request (makes sure its the last ID for nested resources)
        // $id = $this->crud->getCurrentEntryId() ?? $id;
        // // get the info for that entry

        // // $this->data['entry'] = $this->crud->with('invoices')->findOrFail($id)->invoices;
        // $this->data['entry'] = $this->crud->getEntryWithLocale($id);
        // // $this->crud->setOperationSetting('fields', $this->crud->getUpdateFields());

        // $this->data['crud'] = $this->crud;
        // // $this->data['saveAction'] = $this->crud->getSaveAction();
        // // $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::program_costum.pay').' '.$this->crud->entity_name;
        // $this->data['id'] = $id;
        // // dd($this->crud->getEntries());
        // // dd($this->crud->with('invoices')->getEntries($id));
        // $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);
        // // load the view
        // // dd($this->data['entry']);
        // return view('crud::operations.pay_invoice', $this->data);
    }


    public function PayInvoice(){
        
        // $entries = $this->crud->getRequest()->input('entries');
        // $clonedEntries = [];
        // dd($entries);

        // foreach ($entries as $key => $id) {
        //     if ($entry = $this->crud->model->find($id)) {
        //         $clonedEntries[] = $entry->replicate()->push();
        //     }
        // }

        // dd($clonedEntries);
        
        // Check first if the id of the student_id is same do query to find the sudent_id in this invoice tbel
        $id = base64_encode(serialize($this->crud->getRequest()->input('entries')));
        // $this->crud->getRequest()->input('personal_discount');

        // return view('crud::operations.pay_invoice', $entries);

        // dd(self::$myCustomrouteName);

        // return redirect()->route('profile', ['id' => 1]);
        return route('invoice.PreviewInvoice', compact('id'));
        // return redirect()->route('invoice.PreviewInvoice', compact('id'));


        // return $entries;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function PreviewInvoice($id)
    {
        
        // CRUD::hasAccessOrFail('listInvoice');
        $extract = unserialize(base64_decode($id));

        $this->data['crud'] = $this->crud;

        for ($i=0; $i < count($extract); $i++) { 
            if ($entry = $this->crud->model->with('student')->find($extract[$i])) {
                $this->data['entry'][] = $entry;
            }
        }
        
        return view('crud::operations.pay_invoice', $this->data);

    }
}