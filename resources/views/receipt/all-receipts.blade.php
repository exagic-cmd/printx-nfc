@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop
@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">All Records</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Records</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--end::App Content Header-->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">All Records</h3>
                    </div>
                    <div class="card-body table-responsive">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <table id="example1" class="table table-bordered table-striped w-100">
                            @php $counter = 1; @endphp
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Organization</th>
                                    <th>Phone</th>
                                    <!--<th>Phone 2</th>-->
                                    <!--<th>Email</th>-->
                                    <th>Website</th>
                                    <!--<th>Facebook</th>-->
                                    <!--<th>Instagram</th>-->
                                    <!--<th>Office Address</th>-->
                                    <!--<th>Office Number</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receipts as $receipt)
                                    <tr id="receipt-{{ $receipt->id }}">
                                        <td>{{ $counter }}</td>
                                        <td>{{ $receipt->name }}</td>
                                        <td>{{ $receipt->designation ?? 'N/A' }}</td>
                                        <td>{{ $receipt->organization->name ?? 'N/A' }}</td>
                                        <td>{{ $receipt->phone ?? 'N/A' }}</td>
                                        <!--<td>{{ $receipt->phone2 ?? 'N/A' }}</td>-->
                                        <!--<td>{{ $receipt->email ?? 'N/A' }}</td>-->
                                        <td>
                                            @if ($receipt->organization && $receipt->organization->website)
                                                <a href="{{ $receipt->organization->website }}" target="_blank" class="text-primary">{{ Illuminate\Support\Str::limit($receipt->organization->website, 30) }}</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <!--<td>-->
                                        <!--    @if ($receipt->organization && $receipt->organization->facebook)-->
                                        <!--        <a href="{{ $receipt->organization->facebook }}" target="_blank" class="text-primary">{{ Illuminate\Support\Str::limit($receipt->organization->facebook, 30) }}</a>-->
                                        <!--    @else-->
                                        <!--        N/A-->
                                        <!--    @endif-->
                                        <!--</td>-->
                                        <!--<td>-->
                                        <!--    @if ($receipt->organization && $receipt->organization->instagram)-->
                                        <!--        <a href="{{ $receipt->organization->instagram }}" target="_blank" class="text-primary">{{ Illuminate\Support\Str::limit($receipt->organization->instagram, 30) }}</a>-->
                                        <!--    @else-->
                                        <!--        N/A-->
                                        <!--    @endif-->
                                        <!--</td>-->
                                        <!--<td>{{ $receipt->organizationAddress->office_address ?? $receipt->organization->office_address ?? 'N/A' }}</td>-->
                                        <!--<td>{{ $receipt->organizationAddress->office_number ?? $receipt->organization->office_number ?? 'N/A' }}</td>-->
                                        <td class="project-actions text-right">
                                            <a href="javascript:void(0)" 
                               class="btn btn-secondary btn-sm copy-link-btn" 
                               data-link="{{ url('/record/' . $receipt->id) }}">
                               <i class="fa fa-bell"></i>Copy URL
                            </a>
                                            <a class="btn btn-primary btn-sm" href="{{ route('receipt.show', App\Models\Receipt::encodeId($receipt->id)) }}">
                                                <i class="fas fa-folder"></i> View
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ route('receipt.edit', $receipt->id) }}">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </a>
                                            <form action="{{ route('receipt.delete', $receipt->id) }}" method="POST" onsubmit="return confirm('Delete this receipt?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
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
                                    <th>Organization</th>
                                    <th>Phone</th>
                                    <!--<th>Phone 2</th>-->
                                    <!--<th>Email</th>-->
                                    <th>Website</th>
                                    <!--<th>Facebook</th>-->
                                    <!--<th>Instagram</th>-->
                                    <!--<th>Office Address</th>-->
                                    <!--<th>Office Number</th>-->
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
    
 $(document).on('click', '.copy-link-btn', function () {
    var link = $(this).data('link');
    navigator.clipboard.writeText(link).then(function () {
        toastr.success('Link copied to clipboard!');
    }).catch(function () {
         toastr.success('Link copied to clipboard!');
    });
});

</script>