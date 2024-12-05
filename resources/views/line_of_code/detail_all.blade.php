
@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <!-- <hr class="my-12" /> -->
 <div class="card">
  
    
    <div class="row row-bordered g-0">
        <h6 class="card-header">Import line of code </h5>
        <div class="col-lg-6 p-4">
            <input name="file" class="form-control form-control-sm mod-inline-50-percent" type="file" id="formFile">
            <button type="submit" class="btn rounded-pill btn-outline-primary waves-effect">
              <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Import
            </button>
        </div>
        
        <div class="col-lg-6 p-4">
          <form action="{{Route('loc.re_edit')}}" method="POST" enctype="multipart/form-data">
              <select id="smallSelect" name="indexKey" class="form-select form-select-sm mod-inline-50-percent">
                <option>Index_group</option>
                @foreach($lstIndex as $index)
                  <option value="{{$index}}"> {{$index}} </option>
                @endforeach
              </select>
            
              <button type="button" class="btn rounded-pill btn-primary waves-effect waves-light">
                <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Fetch
              </button>
          </form>
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
          @foreach($lstLocDetail as $parent)
            
          @endforeach
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
            <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Update
          </button>

          </div>
        </div>
      </div>
  </div>
  
 
  <!--/ Hoverable Table rows -->
   
@stop()