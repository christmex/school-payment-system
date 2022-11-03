<a href="{{ url($crud->route.'/'.$entry->getKey().'/pay-invoice') }}" class="btn btn-sm btn-link text-capitalize"><i class="la la-file-invoice-dollar"></i> pay-invoice</a>
@if ($crud->hasAccess('pay_invoice'))
@endif