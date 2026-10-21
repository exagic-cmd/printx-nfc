@extends('layouts.app')

@section('css')
<style>
  .form-group {
    margin-bottom: 1rem;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@stop

@section('content')
<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Records</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add New Record</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row g-4">
              <!--begin::Col-->
              <div class="col-md-8">
                <!--begin::Different Height-->
                <div class="card card-secondary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Form</div></div>
                  <!--end::Header-->
                  <!--begin::Body-->
                  <div class="card-body">
                  <div class="frm hidden-print">
                    <form id="receiptForm">
                        @csrf

                        <div class="form-group row">
                        <label for="inputName3" class="col-sm-3 col-form-label">Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="name" id="inputName3" class="form-control" />
                      </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputDes3" class="col-sm-3 col-form-label">Designation</label>
                      <div class="col-sm-9">
                        <input  type="text" name="designation" id="inputDes3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputComp3" class="col-sm-3 col-form-label">Company Name</label>
                      <div class="col-sm-9">
                        <input  type="text" name="company" id="inputComp3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputPh3" class="col-sm-3 col-form-label">Phone</label>
                      <div class="col-sm-9">
                        <input  type="text" name="phone" id="inputPh3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputOffP3" class="col-sm-3 col-form-label">Office Phone</label>
                      <div class="col-sm-9">
                        <input  type="text" name="office_phone" id="inputOffP3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-9">
                        <input  type="email" name="email" id="inputEmail3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputWeb3" class="col-sm-3 col-form-label">Website</label>
                      <div class="col-sm-9">
                        <input  type="text" name="website" id="inputWeb3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputFB3" class="col-sm-3 col-form-label">Facebook</label>
                      <div class="col-sm-9">
                        <input  type="text" name="facebook" id="inputFB3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputIns3" class="col-sm-3 col-form-label">Instagram</label>
                      <div class="col-sm-9">
                        <input  type="text" name="instagram" id="inputIns3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputOA3" class="col-sm-3 col-form-label">Office Address</label>
                      <div class="col-sm-9">
                        <input  type="text" name="address" id="inputOA3" class="form-control" />
                      </div>
                      </div>
                     
                      </div>
                      </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    <!--end::Footer-->
                    </form>
                </div>
                  </div>
                  <!--end::Body-->
                </div>
                <!--end::Different Height-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->

    
    

    <!-- Display Area for Receipt -->
    <!-- <div id="receiptDisplay" class="ticket">
    </div> -->
@stop
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
      $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#receiptForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize all form input values

        $.ajax({
            url: "{{ route('receipt.save') }}", // Replace with your actual route
            method: "POST",
            data: formData,
            success: function (response) {
                // Show receipt or confirmation
                toastr.success('Receipt submitted successfully!');
                 setTimeout(function () {
                    window.location.href = "{{ route('all-receipts') }}"; // Replace with your actual route name
                }, 1500);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('An error occurred. Please check the console for details.');
            }
        });
    });
});
    </script>