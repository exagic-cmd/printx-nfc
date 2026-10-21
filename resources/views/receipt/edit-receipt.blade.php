@extends('layouts.app')

@section('css')
<style>
    .form-group {
        margin-bottom: 1rem;
    }
    .profile-preview {
        max-width: 150px;
        max-height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }
    .profile-initials {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 2px solid #ddd;
        background: {{ $record->organization->color_scheme ?? '#003399' }};
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        font-weight: bold;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Records</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Record</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card card-secondary card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">Edit Form</div>
                    </div>
                    <div class="card-body">
                        <div class="frm hidden-print">
                            <form id="receiptForm" action="{{ route('receipt.update', $record->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="organization_id" class="col-sm-3 col-form-label">Organization</label>
                                    <div class="col-sm-9">
                                        <select name="organization_id" id="organization_id" class="form-control @error('organization_id') is-invalid @enderror" required>
                                            <option value="">Select an Organization</option>
                                            @foreach ($organizations as $organization)
                                                <option value="{{ $organization->id }}" {{ old('organization_id', $record->organization_id) == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" id="address_row">
                                    <label for="organization_address_id" class="col-sm-3 col-form-label">Branch Address</label>
                                    <div class="col-sm-9">
                                        <select name="organization_address_id" id="organization_address_id" class="form-control" required>
                                            <option value="">Select a Branch/Address</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputName3" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" id="inputName3" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $record->name) }}" />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputDes3" class="col-sm-3 col-form-label">Designation</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="designation" id="inputDes3" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $record->designation) }}" />
                                        @error('designation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPh3" class="col-sm-3 col-form-label">Phone</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" id="inputPh3" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $record->phone) }}" />
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPh2" class="col-sm-3 col-form-label">Phone 2</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone2" id="inputPh2" class="form-control @error('phone2') is-invalid @enderror" value="{{ old('phone2', $record->phone2) }}" placeholder="Secondary phone number" />
                                        @error('phone2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" id="inputEmail3" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $record->email) }}" />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="profile_picture" class="col-sm-3 col-form-label">Profile Picture</label>
                                    <div class="col-sm-9">
                                        @if($record->profile_picture)
                                            <div class="mb-2">
                                                <img id="currentProfilePicture" src="{{ $record->profile_picture_url }}" alt="Current Profile" class="profile-preview">
                                                <small class="d-block text-muted">Current profile picture</small>
                                            </div>
                                        @else
                                            <div class="mb-2" id="initialsContainer">
                                                <div class="profile-initials">
                                                    {{ $record->initials }}
                                                </div>
                                                <small class="d-block text-muted">Initial placeholder (no image uploaded)</small>
                                            </div>
                                        @endif
                                        <img id="profilePreview" src="" alt="Profile Preview" class="profile-preview mb-2" style="display: none;">
                                        <input type="file" name="profile_picture" id="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*" />
                                        <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB. Leave empty to keep current picture.</small>
                                        @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--end::Body-->
                    <div class="card-footer">
                        <button type="submit" form="receiptForm" class="btn btn-primary">Update</button>
                        <a href="{{ route('all-receipts') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                    <!--end::Footer-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::App Content-->
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Profile picture preview
        $('#profile_picture').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profilePreview').attr('src', e.target.result).show();
                    $('#currentProfilePicture').hide();
                    $('#initialsContainer').hide();
                };
                reader.readAsDataURL(file);
            } else {
                $('#profilePreview').hide();
                $('#currentProfilePicture').show();
                $('#initialsContainer').show();
            }
        });

        const addressRow = $('#address_row');
        const addressSelect = $('#organization_address_id');
        const currentAddressId = "{{ $record->organization_address_id }}";

        function fetchAddresses(orgId, selectedId = null) {
            if (!orgId) {
                addressRow.hide();
                addressSelect.html('<option value="">Select a Branch/Address</option>');
                return;
            }

            $.ajax({
                url: `/organization/${orgId}/addresses`,
                method: 'GET',
                success: function(addresses) {
                    addressSelect.html('<option value="">Select a Branch/Address</option>');
                    if (addresses.length > 0) {
                        addresses.forEach(addr => {
                            const selected = selectedId == addr.id ? 'selected' : '';
                            addressSelect.append(`<option value="${addr.id}" ${selected}>${addr.office_address} (${addr.office_number})</option>`);
                        });
                        addressRow.show();
                    } else {
                        addressRow.hide();
                    }
                }
            });
        }

        $('#organization_id').on('change', function() {
            fetchAddresses($(this).val());
        });

        // Initialize
        if ($('#organization_id').val()) {
            fetchAddresses($('#organization_id').val(), currentAddressId);
        }

        $('#receiptForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('receipt.update', $record->id) }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success('Record updated successfully!');
                    window.location.href = "{{ route('all-receipts') }}";
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors || {};
                    let errorMessage = 'An error occurred. Please check the form.';
                    if (Object.keys(errors).length > 0) {
                        errorMessage = Object.values(errors).flat().join('<br>');
                    }
                    toastr.error(errorMessage);
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection