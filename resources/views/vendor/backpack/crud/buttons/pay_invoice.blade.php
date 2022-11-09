@if ($crud->hasAccess('listInvoice') && $crud->get('list.bulkActions'))
  <a href="javascript:void(0)" onclick="bulkCloneEntries(this)" class="btn btn-sm btn-secondary bulk-button" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-clone"></i> Pay Invoice</a>
  
@endif

@push('after_scripts')
<script>
  if (typeof bulkCloneEntries != 'function') {
    function bulkCloneEntries(button) {

        if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0)
        {
            new Noty({
            type: "warning",
            text: "<strong>{{ trans('backpack::crud.bulk_no_entries_selected_title') }}</strong><br>{{ trans('backpack::crud.bulk_no_entries_selected_message') }}"
          }).show();

          return;
        }
        var message = "{{ __('custom.pay_invoice') }}";
        message = message.replace(":number", crud.checkedItems.length);
        // let elements = document.getElementsByName("personal_discount[]");

        var personal_discount = [];
        $("input[name='personal_discount[]']").each(function() {
            personal_discount.push($( this ).val());
        });

    

        // console.log(elements)
        // show confirm message
        swal({
            title: "{{ trans('backpack::base.warning') }}",
            text: message,
            icon: "warning",
            buttons: {
            cancel: {
            text: "{{ trans('backpack::crud.cancel') }}",
            value: null,
            visible: true,
            className: "bg-secondary",
            closeModal: true,
            },
            delete: {
            text: "Review Payment",
            value: true,
            visible: true,
            className: "bg-primary",
            }
            },
        }).then((value) => {
            if (value) {
                var ajax_calls = [];
                var clone_route = "{{ url($crud->route) }}/pay-invoice";

                // submit an AJAX delete call
                $.ajax({
                    url: clone_route,
                    type: 'POST',
                    data: { entries: crud.checkedItems,personal_discount: personal_discount },
                    success: function(result) {
                        window.location.href = result
                        // alert(result)
                    // Show an alert with the result
                        new Noty({
                            type: "success",
                            text: "<strong>Entries cloned</strong><br>"+crud.checkedItems.length+" new entries have been added."
                        }).show();

                    crud.checkedItems = [];
                    personal_discount = [];
                    crud.table.ajax.reload();
                    },
                    error: function(result) {
                    // Show an alert with the result
                        new Noty({
                            type: "danger",
                            text: "<strong>Cloning failed</strong><br>One or more entries could not be created. Please try again."
                        }).show();
                    }
                });
                }
            });
        }
        // var ajax_calls = [];
        // console.log(crud.checkedItems)
        //       var clone_route = "{{ url($crud->route) }}/"+crud.checkedItems+"/list-invoice";
        //       window.location.href = clone_route;
      
  }
</script>
@endpush