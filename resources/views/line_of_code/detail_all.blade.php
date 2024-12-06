
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
          <form action="{{Route('loc.re_edit', ['type' => 1])}}" method="GET" enctype="multipart/form-data">
              <select id="smallSelect" name="indexKey" class="form-select form-select-sm mod-inline-50-percent">
                <option>Index_group</option>
                @foreach($lstIndex as $index)
                  <option value="{{$index['id']}}"> {{$index['key_value']}} </option>
                @endforeach
              </select>
            
              <button type="submit" class="btn rounded-pill btn-primary waves-effect waves-light">
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
          @if(!empty($lstLocs))
            @php $counter = 1; @endphp
            @foreach($lstLocs as $parent)
              <tr>
                {{-- <td><i class="ri-suitcase-2-line ri-22px text-danger me-4"></i><span>#191817</span></td> --}}
                <td> {{$counter}} </td>
                <td><input type="text" class="form-control" id="basic-default-fullname" value="{{$parent->number_task}}" name="parentNumber"></td>
                <td><input type="text" class="form-control" id="basic-default-fullname" value="" name="childNumber"></td>
                <td>
                  <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                    @foreach ($lstStatus as $key => $status)
                      <option value="{{$key}}" @if($parent->status == $key) selected="true" @endif> {{ $status }} </option>
                    @endforeach
                  </select>
                </td>
                <td><input type="text" class="form-control" id="basic-default-fullname" name="file_change" value="{{$parent->file_change}}"></td>
                <td><input type="text" class="form-control" id="basic-default-fullname" name="php" value="{{$parent->php}}"></td>
                <td><input type="text" class="form-control" id="basic-default-fullname" name="js" value="{{$parent->js}}"></td>
                <td><input type="text" class="form-control" id="basic-default-fullname" name="css" value="{{$parent->css}}"></td>
                <td><input type="text" class="form-control" id="basic-default-fullname" name="tpl" value="{{$parent->tpl}}"></td>
                <td><input type="text" class="form-control" id="basic-default-fullname" name="total" value="{{$parent->total}}"></td>
                <td>
                    <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="branch" > {{$parent->branch}} </textarea>
                </td>
                <td>
                    <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="note" > {{$parent->notes}} </textarea>
                </td>
              </tr>

              @php $counter++; @endphp
              {{-- if isset parent has child task render html --}}
              @if(!empty( $parent->childTasks))
                @foreach($parent->childTasks as $child)
                  <tr>

                    <td> {{$counter}} </td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" disabled value="{{$parent->number_task}}" name="parentNumber"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" value="{{$child->number_task}}" name="childNumber"></td>
                    <td>
                      <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                        @foreach ($lstStatus as $key => $status)
                          <option value="{{$key}}" @if($child->status == $key) selected="true" @endif> {{ $status }} </option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="file_change" value="{{$child->file_change}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="php" value="{{$child->php}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="js" value="{{$child->js}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="css" value="{{$child->css}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="tpl" value="{{$child->tpl}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="total" value="{{$child->total}}"></td>
                    <td>
                        <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="branch"> {{$child->branch}} </textarea>
                    </td>
                    <td>
                      <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="note"> {{$child->notes}} </textarea>
                    </td>
                  </tr>
                @endforeach
              @php $counter++; @endphp
              @endif
              
            @endforeach
          @endif
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