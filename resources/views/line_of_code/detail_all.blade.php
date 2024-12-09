
@extends('layouts/admin_layout')
{{-- @section('jsStart')
<script src="{{ asset('../assets/js/loc/re_edit.js') }}"></script>
@stop --}}
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

    <div id="alert-container"></div>
</div>

    <div class="card">
    <form id="updateForm" method="POST">
      @csrf
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
                    <td><input type="text" class="form-control" id="basic-default-fullname" disabled value="{{$parent->number_task}}" name="parentNumber"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" disabled value="" name="childNumber"></td>
                    <td>
                      <select class="form-select" id="exampleFormControlSelect1" name="status" aria-label="Default select example">
                        @foreach ($lstStatus as $key => $status)
                          <option value="{{$key}}" @if($parent->status == $key) selected="true" @endif> {{ $status }} </option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="text" class="form-control" id="basic-default-fullname file_change" onchange="updateDateTime({{$parent->id}}, false)" name="fileChange" value="{{$parent->file_change}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="php" value="{{$parent->php}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="js" value="{{$parent->js}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="css" value="{{$parent->css}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="tpl" value="{{$parent->tpl}}"></td>
                    <td><input type="text" class="form-control" id="basic-default-fullname" name="total" value="{{$parent->total}}"></td>
                    <td>
                        <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="branch" > {{$parent->branch}} </textarea>
                    </td>
                    <td>
                        <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="notes" > {{$parent->notes}} </textarea>
                    </td>
                    <input type="hidden" style="display:none" name="typeUpdate" value="parent">
                    <input type="hidden" style="display:none" name="id" value="{{$parent->id}}">
                  </tr>

                  @php $counter++; @endphp
                  {{-- if isset parent has child task render html --}}
                  @if(!empty( $parent->childTasks))
                    @foreach($parent->childTasks as $child)
                      <tr>
                        <td> {{$counter}} </td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" disabled value="{{$parent->number_task}}" name="parentNumber"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" disabled value="{{$child->number_task}}" name="childNumber"></td>
                        <td>
                          <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="status">
                            @foreach ($lstStatus as $key => $status)
                              <option value="{{$key}}" @if($child->status == $key) selected="true" @endif> {{ $status }} </option>
                            @endforeach
                          </select>
                        </td>
                        <td><input type="text" class="form-control" id="basic-default-fullname file_change" onchange="updateDateTime({{$child->id}}, false)" name="fileChange" value="{{$child->file_change}}"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" name="php" value="{{$child->php}}"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" name="js" value="{{$child->js}}"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" name="css" value="{{$child->css}}"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" name="tpl" value="{{$child->tpl}}"></td>
                        <td><input type="text" class="form-control" id="basic-default-fullname" name="total" value="{{$child->total}}"></td>
                        <td>
                            <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="branch"> {{$child->branch}} </textarea>
                        </td>
                        <td>
                          <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="notes"> {{$child->notes}} </textarea>
                        </td>
                        <input type="hidden" style="display:none" name="typeUpdate" value="child">
                        <input type="hidden" style="display:none" name="id" value="{{$child->id}}">
                      </tr>
                      @php $counter++; @endphp
                    @endforeach
               
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
              <button type="button" onclick="updateAll()" class="btn rounded-pill btn-outline-primary waves-effect">
                <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Update
              </button>

              </div>
            </div>
          </div>
      </div>
    </form>  {{-- form sumary --}}
 
  <!--/ Hoverable Table rows -->
   
@stop()
@section('js')
<script>
  function updateDateTime(id, isParent) {
      $.ajax({
          url: 'update/loc_datetime',
          method: 'POST',
          data: {
              _token: '{{ csrf_token() }}',
              id: id,
              isParent: isParent
          },
          success: function(response) {
              if (response.success) {
                  var alertHtml = `
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          ${response.message}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  `;
                  $('#alert-container').html(alertHtml);

                  addTimeOut();
              } else {
                  var alertHtml = `
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          ${response.message}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  `;
                  $('#alert-container').html(alertHtml);
              }
          },
          error: function(xhr, status, error) {
              // Nếu có lỗi trong việc gửi request (không liên quan đến logic của app)
              console.log('Error:', error);
              var alertHtml = `
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      Unexpected error occurred. Please try again.
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              `;
              $('#alert-container').html(alertHtml);
          }
      })

      setTimeout(function () {
            $('#alert-container .alert').alert('close'); // Đóng alert
      }, 200);
  }


  function updateAll() {
      const tableRows = document.querySelectorAll('#updateForm table tbody tr');
      const data = {};

      tableRows.forEach((row) => {
          const id           = row.querySelector('[name="id"]')?.value;
          const parentNumber = row.querySelector('[name="parentNumber"]')?.value || '';
          const childNumber  = row.querySelector('[name="childNumber"]')?.value || '';
          const status       = row.querySelector('[name="status"]')?.value || '';
          const fileChange   = row.querySelector('[name="fileChange"]')?.value || '';
          const php          = row.querySelector('[name="php"]')?.value || '';
          const js           = row.querySelector('[name="js"]')?.value || '';
          const css          = row.querySelector('[name="css"]')?.value || '';
          const tpl          = row.querySelector('[name="tpl"]')?.value || '';
          const total        = row.querySelector('[name="total"]')?.value || '';
          const branch       = row.querySelector('[name="branch"]')?.value || '';
          const notes        = row.querySelector('[name="notes"]')?.value || '';
          const typeUpdate   = row.querySelector('[name="typeUpdate"]')?.value || '';

          if (id) {
              // Group data
              data[id] = {
                  id,
                  parentNumber,
                  childNumber,
                  status,
                  fileChange,
                  php,
                  js,
                  css,
                  tpl,
                  total,
                  branch,
                  notes,
                  typeUpdate,
              };
          }
      });

      console.log('Collected data:', data);

      fetch('/_admin/loc/re_edit/update/update-all', {
              method: 'POST',
              headers: {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify(data),
          })
          .then((response) => {
              if (!response.ok) {
                  return response.json().then((errData) => {
                      throw new Error(errData.message || `HTTP Error ${response.status}`);
                  });
              }
              return response.json();
          })
          .then((data) => {
              console.log('Response from server:', data);

              let successMessages = data.success.join('\n');
              let errorMessages = data.errors.join('\n');

              if (data.success.length > 0) {
                  alert('Updated successfully:\n' + successMessages);
              }

              if (data.errors.length > 0) {
                  alert('Failed updates:\n' + errorMessages);
              }
          })
          .catch((error) => {
              console.error('Error:', error.message || error);
              alert('Something went wrong: ' + (error.message || error));
          });      
  }

  document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#updateForm table tbody tr');
  
    rows.forEach(row => {
      // const rowId = row.id;
  
      const phpInput   = row.querySelector('input[name="php"]');
      const jsInput    = row.querySelector('input[name="js"]');
      const cssInput   = row.querySelector('input[name="css"]');
      const tplInput   = row.querySelector('input[name="tpl"]');
      const totalInput = row.querySelector('input[name="total"]');
    
      function updateTotal() {
        const phpValue = parseInt(phpInput.value) || 0;
        const jsValue  = parseInt(jsInput.value) || 0;
        const cssValue = parseInt(cssInput.value) || 0;
        const tplValue = parseInt(tplInput.value) || 0;
        
        const total = phpValue + jsValue + cssValue + tplValue;
        
        totalInput.value = total;
        // totalInput.value = total.toFixed(2);
      }

      // Listening 'input' at input php, js, css, tpl in row current !
      phpInput.addEventListener('input', updateTotal);
      jsInput.addEventListener('input', updateTotal);
      cssInput.addEventListener('input', updateTotal);
      tplInput.addEventListener('input', updateTotal);
      
      // Process caculator data when Firt Load !
      updateTotal();
    });
  });

  function addTimeOut(){
    setTimeout(function () {
                      $('#alert-container .alert').alert('close');
    }, 2000); // 2 giây
  }

</script>
@stop