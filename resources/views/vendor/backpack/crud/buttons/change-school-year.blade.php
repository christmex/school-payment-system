
@if($crud->hasAccess('list'))
    <!-- if(!$entry->is_active && $entry->school_year_start == date('Y') + 1 && $entry->school_year_start == date('Y')) -->
    <!-- if(!$entry->is_active && $entry->school_year_start > 2023 && $entry->school_year_start < 2023 + 1) -->
    @if(!$entry->is_active && $entry->school_year_start == date('Y'))
    <a href="javascript:void(0)" onclick="changeSchoolYear('{{$entry->getKey()}}')" class=""><i class="la la-exchange-alt"></i> Aktifkan</a>
    @endif 

@endif

<script>
  if (typeof changeSchoolYear != 'function') {
    function changeSchoolYear(id) {
      var message = "Apakah anda yakin akan mengaktifkan tahun ajaran ini?";

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
            text: "Aktifkan",
            value: true,
            visible: true,
            className: "bg-primary",
            }
            },
        }).then((value) => {
            if (value) {
              // alert(id)
              var url = "{{ url($crud->route) }}/activate";
              $.ajax({
                    url: url,
                    type: 'POST',
                    data: { id: id },
                    success: function(result) {
                      crud.table.ajax.reload();
                      console.log(result.responseText)
                      new Noty({
                          type: "success",
                          text: `<strong>Berhasil</strong><br> ${result}`
                      }).show();
                    },
                    error: function(result) {
                      crud.table.ajax.reload();
                      // alert(result.responseText)
                    // Show an alert with the result
                        new Noty({
                          type: "danger",
                          text: `<strong>Gagal</strong><br> ${result.responseText}`
                        }).show();
                    }
                });
                
              }
            });
        }
    }
  
</script>