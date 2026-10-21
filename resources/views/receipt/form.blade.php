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
        display: none;
    }
    .required{
        color:red;
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
                    <li class="breadcrumb-item active" aria-current="page">Add New Record</li>
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
                        <div class="card-title">Form</div>
                    </div>
                    <div class="card-body">
                        <div class="frm hidden-print">
                            <form id="receiptForm" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="organization_id" class="col-sm-3 col-form-label">Organization <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="organization_id" id="organization_id" class="form-control @error('organization_id') is-invalid @enderror" required {{ auth()->guard('organization')->check() ? 'disabled' : '' }}>
                                            <option value="">Select an Organization</option>
                                            @foreach ($organizations as $organization)
                                                <option value="{{ $organization->id }}" {{ (auth()->guard('organization')->check() && auth()->guard('organization')->id() == $organization->id) || old('organization_id') == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                                            @endforeach
                                        </select>
                                        @if(auth()->guard('organization')->check())
                                            <input type="hidden" name="organization_id" value="{{ auth()->guard('organization')->id() }}">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row" id="address_row" style="display:none;">
                                    <label for="organization_address_id" class="col-sm-3 col-form-label">Branch Address <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="organization_address_id" id="organization_address_id" class="form-control" required>
                                            <option value="">Select a Branch/Address</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputName3" class="col-sm-3 col-form-label">Name <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" id="inputName3" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputDes3" class="col-sm-3 col-form-label">Designation <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="designation" id="inputDes3" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation') }}" />
                                        @error('designation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPh3" class="col-sm-3 col-form-label">Phone <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" id="inputPh3" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" />
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPh2" class="col-sm-3 col-form-label">Phone 2</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone2" id="inputPh2" class="form-control @error('phone2') is-invalid @enderror" value="{{ old('phone2') }}" placeholder="Secondary phone number" />
                                        @error('phone2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" id="inputEmail3" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="profile_picture" class="col-sm-3 col-form-label">Profile Picture <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <img id="profilePreview" src="" alt="Profile Preview" class="profile-preview mb-2">
                                        <input type="file" name="profile_picture" id="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*" />
                                        <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB</small>
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
                        <button type="submit" form="receiptForm" class="btn btn-primary">Save</button>
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
                };
                reader.readAsDataURL(file);
            } else {
                $('#profilePreview').hide();
            }
        });

        const addressRow = $('#address_row');
        const addressSelect = $('#organization_address_id');

        function fetchAddresses(orgId) {
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
                            addressSelect.append(`<option value="${addr.id}">${addr.office_address} (${addr.office_number})</option>`);
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

        // Initialize if already selected (for organization login)
        if ($('#organization_id').val()) {
            fetchAddresses($('#organization_id').val());
        }

        $('#receiptForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('receipt.save') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success('Receipt submitted successfully!');
                    $('#receiptForm')[0].reset();
                    $('#profilePreview').hide();
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