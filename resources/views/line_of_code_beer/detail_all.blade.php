
@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <!-- <hr class="my-12" /> -->
 <div class="card">
  
    
    <div class="row row-bordered g-0">
        <h6 class="card-header">Import line of code </h5>
        <div class="col-lg-4 p-6">
            <input class="form-control" type="file" id="formFile">
        </div>
        <div class="col-lg-4 p-6">
        <select id="smallSelect" class="form-select form-select-sm">
            <option>Index_group</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
         
        </div>
        <div class="col-lg-4 p-6">
          <button type="button" class="btn rounded-pill btn-primary waves-effect waves-light">
            <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Fetch
          </button>
           
        </div>
      
    </div>
</div>

    <div class="card">
    
    <div class="table-responsive text-nowrap">
     
      <!-- Config child table -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th>STT</th>
            <th>Parent task</th>
            <th>Child task</th>
            <th>Status</th>
            <th>File_CH</th>
            <th>PHP</th>
            <th>JS</th>
            <th>CSS</th>
            <th>TPL</th>
            <th>Total</th>
            <th>Branch</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <tr>
            {{-- <td><i class="ri-suitcase-2-line ri-22px text-danger me-4"></i><span>#191817</span></td> --}}
            <td>1</td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="#1989273"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="#1989273"></td>
            <td>
              <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option selected="">Status</option>
                <option value="1">New</option>
                <option value="2">Inprocess</option>
                <option value="3">Reslove</option>
                <option value="3">Done</option>
              </select>
            </td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="11"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="97"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="67"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="32"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="32"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="132"></td>
            <td>
                <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" placeholder="Branch..."></textarea>
              </td>
            <td>
              <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" placeholder="Comments here..."></textarea>
            </td>
          </tr>

          
        </tbody>
                     
      </table>
      <!-- Config child table -->
    </div>
  </div>

  <div class="col-12">
    <div class="card mb-6">
      <div class="row row-bordered g-0">
        <div class="col-lg-4 p-6">
          <button type="button" class="btn rounded-pill btn-outline-primary waves-effect">
            <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Save
          </button>

          <button type="button" class="btn btn-icon btn-outline-secondary waves-effect" id="addRowBtn">
            <span class="tf-icons line ri-22px"> + </span>
          </button>
          </div>
        </div>
      </div>
  </div>
  
 
  <!--/ Hoverable Table rows -->
   
@stop()

@section('js')
<script src="{{asset('../assets/js/loc/edit_ui.js')}}"></script>
@stop