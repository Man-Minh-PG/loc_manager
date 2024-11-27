
@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <!-- <hr class="my-12" /> -->
 <div class="card">
    <h5 class="card-header">Edit line of code : - time: 2024-11 </h5>
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Parent task</th>
            <th>Status</th>
            <th>File_change</th>
            <th>PHP</th>
            <th>JS</th>
            <th>CSS</th>
            <th>TPL</th>
            <th>Total</th>
            <th>Create at</th>
            <th>Note</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <tr>
            <td><a href="">#1989273</a></td>
            <td>Done</td>
            <td>11 File</td>
            <td>97</td>
            <td>67</td>
            <td>32</td>
            <td>32</td>
            <td>132</td>
            <td>2024:11:22 11:22:11</td>
            <td>note 123</td>
          </tr>
        </tbody>

      </table>
      <hr class="my-12" />
      <!-- Config child table -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th>child task</th>
            <th>Status</th>
            <th>File_change</th>
            <th>PHP</th>
            <th>JS</th>
            <th>CSS</th>
            <th>TPL</th>
            <th>Total</th>
            <th>Create at</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <tr>
            {{-- <td><i class="ri-suitcase-2-line ri-22px text-danger me-4"></i><span>#191817</span></td> --}}
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="#1989273"></td>
            <td>
              <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                <option selected="">Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="11 File"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="97"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="67"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="32"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="32"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="132"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="2024:11:22 11:22:11"></td>
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
          </div>
        </div>
      </div>
  </div>
  
 
  <!--/ Hoverable Table rows -->
   
@stop()