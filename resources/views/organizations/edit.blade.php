@extends('layouts.app')

@section('content')
<style>
    .org-initials-preview {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        background: {{ $organization->color_scheme ?? '#0d6efd' }};
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="mb-0">Edit Organization</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Whoops!</strong> Please fix the following errors:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @php
                $formAction = auth()->guard('organization')->check() ? route('organization.profile.update') : route('organizations.update', $organization->id);
                $cancelRoute = auth()->guard('organization')->check() ? route('dashboard') : route('organizations.index');
            @endphp

            <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Organization Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $organization->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email (for Login)</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $organization->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="password" class="form-label">Password (leave blank to keep current)</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $organization->website) }}" placeholder="https://example.com">
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="facebook" class="form-label">Facebook</label>
                    <input type="url" name="facebook" id="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook', $organization->facebook) }}" placeholder="https://facebook.com/yourpage">
                    @error('facebook')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input type="url" name="instagram" id="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram', $organization->instagram) }}" placeholder="https://instagram.com/yourpage">
                    @error('instagram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <h4>Office Locations</h4>
                <div id="addresses-container">
                    @forelse($organization->addresses as $index => $address)
                        <div class="address-row border p-3 mb-3 rounded bg-light" data-id="{{ $address->id }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Address #{{ $index + 1 }}</h5>
                                <button type="button" class="btn btn-danger btn-sm remove-address" style="{{ $loop->first ? 'display:none;' : '' }}">Remove</button>
                            </div>
                            <input type="hidden" name="addresses[{{ $index }}][id]" value="{{ $address->id }}">
                            <div class="mb-3">
                                <label class="form-label">Office Address</label>
                                <textarea name="addresses[{{ $index }}][office_address]" class="form-control" rows="2" required>{{ old("addresses.$index.office_address", $address->office_address) }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Office Number</label>
                                    <input type="text" name="addresses[{{ $index }}][office_number]" class="form-control" value="{{ old("addresses.$index.office_number", $address->office_number) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fax Number</label>
                                    <input type="text" name="addresses[{{ $index }}][fax_number]" class="form-control" value="{{ old("addresses.$index.fax_number", $address->fax_number) }}">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="address-row border p-3 mb-3 rounded bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Address #1</h5>
                                <button type="button" class="btn btn-danger btn-sm remove-address" style="display:none;">Remove</button>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Office Address</label>
                                <textarea name="addresses[0][office_address]" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Office Number</label>
                                    <input type="text" name="addresses[0][office_number]" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fax Number</label>
                                    <input type="text" name="addresses[0][fax_number]" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button type="button" id="add-address" class="btn btn-info btn-sm mb-3">Add More Address</button>
                <hr>

                <div class="mb-3 col-md-6">
                    <label for="logo" class="form-label">Logo</label>
                    @if($organization->logo)
                        <div class="mb-2">
                            <img src="{{ $organization->logo_url }}" alt="Current Logo" style="max-height: 100px; max-width: 200px;" class="img-thumbnail">
                            <small class="d-block text-muted">Current logo</small>
                        </div>
                    @else
                        <div class="mb-2">
                            <div class="org-initials-preview">
                                {{ $organization->initials }}
                            </div>
                            <small class="d-block text-muted">Current fallback (initials)</small>
                        </div>
                    @endif
                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB. Leave empty to keep current logo.</small>
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="color_scheme" class="form-label">Color Scheme</label>
                    <div class="input-group">
                        <input type="color" id="color_scheme_picker" class="form-control form-control-color @error('color_scheme') is-invalid @enderror" value="{{ old('color_scheme', $organization->color_scheme ?? '#000000') }}" title="Choose your color" style="min-width: 60px; max-width: 60px; padding: 0.375rem;">
                        <input type="text" name="color_scheme" id="color_scheme" class="form-control @error('color_scheme') is-invalid @enderror" value="{{ old('color_scheme', $organization->color_scheme ?? '#000000') }}" placeholder="#000000" maxlength="7" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                        <span class="input-group-text" id="color_scheme_preview" style="width: 50px; background-color: {{ old('color_scheme', $organization->color_scheme ?? '#000000') }};"></span>
                    </div>
                    <small class="text-muted">Click the color box to pick a color or enter a hex code (e.g., #FF5733)</small>
                    @error('color_scheme')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="background_color" class="form-label">Record Background Color</label>
                    <div class="input-group">
                        <input type="color" id="background_color_picker" class="form-control form-control-color @error('background_color') is-invalid @enderror" value="{{ old('background_color', $organization->background_color ?? '#ffffff') }}" title="Choose background color" style="min-width: 60px; max-width: 60px; padding: 0.375rem;">
                        <input type="text" name="background_color" id="background_color" class="form-control @error('background_color') is-invalid @enderror" value="{{ old('background_color', $organization->background_color ?? '#ffffff') }}" placeholder="#ffffff" maxlength="7" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                        <span class="input-group-text" id="background_color_preview" style="width: 50px; background-color: {{ old('background_color', $organization->background_color ?? '#ffffff') }};"></span>
                    </div>
                    <small class="text-muted">This color will be applied to the background of records.</small>
                    @error('background_color')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Organization</button>
                <a href="{{ $cancelRoute }}" class="btn btn-secondary ms-2" onclick="return confirm('Are you sure you want to cancel? Unsaved changes will be lost.')">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generic color sync function
    function syncColor(pickerId, inputId, previewId) {
        const picker = document.getElementById(pickerId);
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        picker.addEventListener('input', function() {
            input.value = this.value.toUpperCase();
            preview.style.backgroundColor = this.value;
        });

        input.addEventListener('input', function() {
            let value = this.value;
            if (value && !value.startsWith('#')) {
                value = '#' + value;
                this.value = value;
            }
            if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(value)) {
                picker.value = value;
                preview.style.backgroundColor = value;
            }
        });
    }

    syncColor('color_scheme_picker', 'color_scheme', 'color_scheme_preview');
    syncColor('background_color_picker', 'background_color', 'background_color_preview');

    // Dynamic Addresses
    let addressCount = {{ count($organization->addresses) ?: 1 }};
    const container = document.getElementById('addresses-container');
    const addButton = document.getElementById('add-address');

    addButton.addEventListener('click', function() {
        // Clone the first row as template
        const template = container.querySelector('.address-row');
        const newRow = template.cloneNode(true);
        addressCount++;
        
        newRow.querySelector('h5').textContent = `Address #${addressCount}`;
        newRow.querySelector('.remove-address').style.display = 'block';
        
        // Remove hidden ID input if it exists in the new row
        const hiddenId = newRow.querySelector('input[type="hidden"][name*="[id]"]');
        if (hiddenId) hiddenId.remove();

        // Reset inputs
        newRow.querySelectorAll('input, textarea').forEach(input => {
            input.value = '';
            const name = input.getAttribute('name');
            input.setAttribute('name', name.replace(/\[\d+\]/, `[${addressCount - 1}]`));
        });
        
        container.appendChild(newRow);
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-address')) {
            e.target.closest('.address-row').remove();
            // Re-index
            container.querySelectorAll('.address-row').forEach((row, index) => {
                row.querySelector('h5').textContent = `Address #${index + 1}`;
                row.querySelectorAll('input, textarea, input[type="hidden"]').forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                    }
                });
            });
            addressCount--;
        }
    });

    // Password Visibility Toggle
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
});
</script>
@endsection