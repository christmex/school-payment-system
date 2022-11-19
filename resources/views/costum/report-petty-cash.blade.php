<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
</head>
<body class="app flex-row align-items-center">


  <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                <thead>
                <tr>
                    <th colspan="4">as</th>
                </tr>
                <!-- <tr>
                    <th>as</th>
                    <th>as</th>
                    <th>as</th>
                    <th>as</th>
                </tr> -->
                </thead>
                <tbody>
                   <tr>
                        <td>VA</td>
                        <td>asdasd</td>
                        <td>asdasd</td>
                        <td>asdasd</td>
                   </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>as</th>
                        <th>as</th>
                        <th>as</th>
                        <th>as</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
  </div>

  

  @include(backpack_view('inc.scripts'))


</body>
</html>
