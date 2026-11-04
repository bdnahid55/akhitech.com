<div class="row">
  <!-- col -->
  <div class="col-12">
    
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">DataTable with default features</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Rendering engine</th>
            <th>Browser</th>
            <th>Platform(s)</th>
            <th>Engine version</th>
            <th>CSS grade</th>
          </tr>
          </thead>
          <tbody>

          <tr>
            <td>Trident</td>
            <td>নাজমুল</td>
            <td>Win 95+</td>
            <td> 4</td>
            <td>X</td>
          </tr>
          <tr>
            <td>Trident</td>
            <td>InternetExplorer 5.0</td>
            <td>Win 95+</td>
            <td>5</td>
            <td>C</td>
          </tr>
          <tr>
            <td>Gecko</td>
            <td>Mozilla 1.4</td>
            <td>Win 95+ / OSX.1+</td>
            <td>1.4</td>
            <td>A</td>
          </tr>

          </tbody>
          <tfoot>
          <tr>
            <th>Rendering engine</th>
            <th>Browser</th>
            <th>Platform(s)</th>
            <th>Engine version</th>
            <th>CSS grade</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>

  </div>
  <!-- ./col -->
</div>
<!-- /.row -->

<!-- Page specific script -->
<script>
  $(function () {

    // Datatables
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "print", "colvis"]
      // for colvis to work properly start
      .map(function(btn) {
          return {
              extend: btn,
              exportOptions: {
                  columns: ':visible'
              }
          };
      })
      // for colvis to work properly end
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    // End
  });
</script>
