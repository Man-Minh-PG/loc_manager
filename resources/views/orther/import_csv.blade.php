
@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <!-- <hr class="my-12" /> -->
 <div class="card">
    <div class="row row-bordered g-0">
      <form action="{{Route('loc.import_csv')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <h6 class="card-header">Import line of code </h5>
          <div class="col-lg-8 p-4">
              <input name="file" class="form-control mod-inline-50-percent" type="file" id="formFile">
              <button type="submit" class="btn rounded-pill btn-outline-primary waves-effect">
                <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Import
              </button>
          </div>
      </form>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Oops! There were some errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
</div>
   
@stop()

@section('js')
<script src="{{asset('../assets/js/loc/edit_ui.js')}}"></script>
@stop