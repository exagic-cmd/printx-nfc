@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <h2 class="mb-4 card-header">Create New Organization</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following errors:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
    <form action="{{ route('organizations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Organization Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email (for Login)</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" name="website" class="form-control" value="{{ old('website') }}">
        </div>

        <div class="mb-3">
            <label for="facebook" class="form-label">Facebook</label>
            <input type="url" name="facebook" class="form-control" value="{{ old('facebook') }}">
        </div>

        <div class="mb-3">
            <label for="instagram" class="form-label">Instagram</label>
            <input type="url" name="instagram" class="form-control" value="{{ old('instagram') }}">
        </div>

        <hr>
        <h4>Office Locations</h4>
        <div id="addresses-container">
            <div class="address-row border p-3 mb-3 rounded bg-light">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Address #1</h5>
                    <button type="button" class="btn btn-danger btn-sm remove-address" style="display:none;">Remove</button>
                </div>
                <div class="mb-3">
                    <label class="form-label">Office Address</label>
                    <textarea name="addresses[0][office_address]" class="form-control" rows="2" >{{ old('addresses.0.office_address') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Office Number</label>
                        <input type="text" name="addresses[0][office_number]" class="form-control" value="{{ old('addresses.0.office_number') }}" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fax Number</label>
                        <input type="text" name="addresses[0][fax_number]" class="form-control" value="{{ old('addresses.0.fax_number') }}">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="add-address" class="btn btn-info btn-sm mb-3">Add More Address</button>
        <hr>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB</small>
        </div>

        <div class="mb-3">
            <label for="color_scheme" class="form-label">Color Scheme</label>
            <div class="input-group">
                <input type="color" id="color_picker" class="form-control form-control-color" value="{{ old('color_scheme', '#000000') }}" title="Choose your color" style="min-width: 60px; max-width: 60px; padding: 0.375rem;">
                <input type="text" name="color_scheme" id="color_scheme" class="form-control" value="{{ old('color_scheme', '#000000') }}" placeholder="#000000" maxlength="7" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                <span class="input-group-text" id="color_preview" style="width: 50px; background-color: {{ old('color_scheme', '#000000') }};"></span>
            </div>
            <small class="text-muted">Click the color box to pick a color or enter a hex code (e.g., #FF5733)</small>
        </div>

        <div class="mb-3">
            <label for="background_color" class="form-label">Record Background Color</label>
            <div class="input-group">
                <input type="color" id="bg_color_picker" class="form-control form-control-color" value="{{ old('background_color', '#ffffff') }}" title="Choose background color" style="min-width: 60px; max-width: 60px; padding: 0.375rem;">
                <input type="text" name="background_color" id="background_color" class="form-control" value="{{ old('background_color', '#ffffff') }}" placeholder="#ffffff" maxlength="7" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                <span class="input-group-text" id="bg_color_preview" style="width: 50px; background-color: {{ old('background_color', '#ffffff') }};"></span>
            </div>
            <small class="text-muted">This color will be applied to the background of records.</small>
        </div>

        <button type="submit" class="btn btn-primary">Create Organization</button>
        <a href="{{ route('organizations.index') }}" class="btn btn-secondary ms-2">Cancel</a>
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

    syncColor('color_picker', 'color_scheme', 'color_preview');
    syncColor('bg_color_picker', 'background_color', 'bg_color_preview');

    // Dynamic Addresses
    let addressCount = 1;
    const container = document.getElementById('addresses-container');
    const addButton = document.getElementById('add-address');

    addButton.addEventListener('click', function() {
        const newRow = container.querySelector('.address-row').cloneNode(true);
        addressCount++;
        
        newRow.querySelector('h5').textContent = `Address #${addressCount}`;
        newRow.querySelector('.remove-address').style.display = 'block';
        
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
                row.querySelectorAll('input, textarea').forEach(input => {
                    const name = input.getAttribute('name');
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
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
