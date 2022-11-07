<a href="{{ url($crud->route.'/'.$entry->getKey().'/list-invoice') }}" class="btn btn-sm btn-link text-capitalize"><i class="la la-file-invoice-dollar"></i> Invoice</a>
@if ($crud->hasAccess('pay_invoice'))
@endif