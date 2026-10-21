@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop


@section('content')

<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">All Records</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">All Records</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
<!-- Content Wrapper. Contains page content -->
  <div class="app-content">
   

    <!-- Main content -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Records</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                   @php $counter = 1; @endphp
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Office Phone</th>
                    <th>Email</th>
                    <!--<th>Website</th>-->
                    <!--<th>Facebook</th>-->
                    <!--<th>Instagram</th>-->
                    <!--<th>Office Address</th>-->
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  	  @foreach($receipts as $receipt)
                  <tr>
                    <td>{{ $counter }}</td>
                <td>{{ $receipt->name }}</td>
                <td>{{ $receipt->designation }}</td>
                <td>{{ $receipt->company }}</td>
                <td>{{ $receipt->phone }}</td>
                <td>{{ $receipt->office_phone }}</td>
                <td>{{ $receipt->email }}</td>
                <!--<td>{{ $receipt->website }}</td>-->
                <!--<td>{{ $receipt->facebook }}</td>-->
                <!--<td>{{ $receipt->instagram }}</td>-->
                <!--<td>{{ $receipt->address }}</td>-->
             
                    <td class="project-actions text-right">
                        <a href="javascript:void(0)" 
                               class="btn btn-secondary btn-sm copy-link-btn" 
                               data-link="{{ url('/record/' . $receipt->id) }}">
                               <i class="fa fa-bell"></i>Copy URL
                            </a>
                          <a class="btn btn-primary btn-sm" href="{{ $receipt->id }}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" href="{{ route('receipt.edit', $receipt->id) }}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                         
                          <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $receipt->id }}">Delete</button>
                </td>
                  </tr>
                   @php $counter++; @endphp
                  @endforeach



                  </tbody>
                  <tfoot>
                  <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Office Phone</th>
                    <th>Email</th>
                    <!--<th>Website</th>-->
                    <!--<th>Facebook</th>-->
                    <!--<th>Instagram</th>-->
                    <!--<th>Office Address</th>-->
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@stop

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
 <script>
    $(document).ready(function () {
        $(".delete-btn").on("click", function () {
            var receiptId = $(this).data("id");

            if (confirm("Are you sure you want to delete this Record?")) {
                $.ajax({
                    url: "/receipt/" + receiptId,
                    type: "POST",  // Change from DELETE to POST
                    data: {
                        _method: "DELETE", // Laravel requires this for DELETE requests
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $("#receipt-" + receiptId).remove(); // Remove row from table
                        alert(response.success);
                       location.reload();
                    },
                    error: function () {
                        toastr.error("An error occurred while deleting the record.");
                    }

                });
            }
        });
    });
</script>
<script>
    
 $(document).on('click', '.copy-link-btn', function () {
    var link = $(this).data('link');
    navigator.clipboard.writeText(link).then(function () {
        toastr.success('Link copied to clipboard!');
    }).catch(function () {
         toastr.success('Link copied to clipboard!');
    });
});

</script>
