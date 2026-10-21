@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Organizations</h3>
            <a href="{{ route('organizations.create') }}" class="btn btn-secondary">Add New Organization</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="organizations-table" class="table table-bordered table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Website</th>
                            <!--<th>Facebook</th>-->
                            <!--<th>Instagram</th>-->
                            <!--<th>Office Address</th>-->
                            <!--<th>Office Number</th>-->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($organizations as $organization)
                            <tr>
                                <td>{{ $organization->name }}</td>
                                <td>
                                    @if ($organization->website)
                                        <a href="{{ $organization->website }}" target="_blank" class="text-primary">{{ Illuminate\Support\Str::limit($organization->website, 30) }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <!--<td>-->
                                <!--    @if ($organization->facebook)-->
                                <!--        <a href="{{ $organization->facebook }}" target="_blank" class="text-primary">{{ Illuminate\Support\Str::limit($organization->facebook, 30) }}</a>-->
                                <!--    @else-->
                                <!--        N/A-->
                                <!--    @endif-->
                                <!--</td>-->
                                <!--<td>-->
                                <!--    @if ($organization->instagram)-->
                                <!--        <a href="{{ $organization->instagram }}" target="_blank" class="text-primary">{{ Illuminate\Support\Str::limit($organization->instagram, 30) }}</a>-->
                                <!--    @else-->
                                <!--        N/A-->
                                <!--    @endif-->
                                <!--</td>-->
                                <!--<td>{{ $organization->office_address ?? 'N/A' }}</td>-->
                                <!--<td>{{ $organization->office_number ?? 'N/A' }}</td>-->
                                <td>
                                    <a href="{{ route('organizations.edit', $organization->id) }}" class="btn btn-sm btn-warning me-2"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this organization?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection