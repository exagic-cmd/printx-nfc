@extends('layouts.app')

@section('css')
<style>
  .form-group {
    margin-bottom: 1rem;
}
</style>

@stop

@section('content')

<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Edit Record</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a>
                  <li class="breadcrumb-item active" aria-current="page">Edit 
                  Receipt
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row g-4">
              <!--begin::Col-->
              <div class="col-md-8">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header">
                  	<div class="card-title">Update the record</div>
                  </div>
                  <!--end::Header-->
                  <!--begin::Form-->
                  <form action="{{ route('receipt.update', $receipt->id) }}" method="POST">
                  	 @csrf
        			@method('PUT')
                    <!--begin::Body-->
                    <div class="card-body">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="inputName3" class="col-sm-3 col-form-label">Name</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->name }}" type="text" name="name" id="inputName3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputDes3" class="col-sm-3 col-form-label">Designation</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->designation }}" type="text" name="designation" id="inputDes3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputComp3" class="col-sm-3 col-form-label">Company Name</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->company }}" type="text" name="company" id="inputComp3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputPh3" class="col-sm-3 col-form-label">Phone</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->phone }}" type="text" name="phone" id="inputPh3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputOffP3" class="col-sm-3 col-form-label">Office Phone</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->office_phone }}" type="text" name="office_phone" id="inputOffP3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->email }}" type="email" name="email" id="inputEmail3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputWeb3" class="col-sm-3 col-form-label">Website</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->website }}" type="text" name="website" id="inputWeb3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputFB3" class="col-sm-3 col-form-label">Facebook</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->facebook }}" type="text" name="facebook" id="inputFB3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputIns3" class="col-sm-3 col-form-label">Instagram</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->instagram }}" type="text" name="instagram" id="inputIns3" class="form-control" />
                      </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputOA3" class="col-sm-3 col-form-label">Office Address</label>
                      <div class="col-sm-9">
                        <input value="{{ $receipt->address }}" type="text" name="address" id="inputOA3" class="form-control" />
                      </div>
                      </div>
                     
                      </div>
                      </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <!--end::Footer-->
                  </form>
                  <!--end::Form-->
                </div>
                <!--end::Quick Example-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->

@stop
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
	 $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
	$.ajax({
    url: "{{ route('receipt.update', $receipt->id) }}",
    type: "PUT",
    data: $('#updateForm').serialize(),
    success: function(response) {
        alert("Updated Successfully!");
    },
    error: function(xhr) {
        console.log(xhr.responseText);
    }
});

</script>