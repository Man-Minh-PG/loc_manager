@extends('layouts/admin_layout')
{{-- @section('jsStart')
<script src="{{ asset('../assets/js/loc/re_edit.js') }}"></script>
@stop --}}
@section('main')
<!-- Hoverable Table rows -->
<!-- <hr class="my-12" /> -->
<div class="card">

  {{-- validation show msg if error  --}}
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

  {{-- validation show msg if success --}}
  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif


  <div class="row row-bordered g-0">
    <form action="{{Route('loc.UpdateCsv')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <h6 class="card-header">Import line of code </h5>
        <div class="col-lg-8 p-4">
          <input name="file" class="form-control mod-inline-50-percent" type="file" id="formFile">
          <button type="submit" class="btn rounded-pill btn-outline-primary waves-effect">
            <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Import
          </button>
        </div>
    </form>

    <div class="col-lg-9 p-4">
      <form class="mod-inline-50-percent" style="width: 50%; display:inline" action="{{Route('loc.re_edit', ['type' =>  config('common.BEER')]) }}" method="GET" enctype="multipart/form-data">
        <select id="smallSelect" name="indexKey" class="form-select form-select-sm mod-inline-30-percent">
          <option>Index_group</option>
          @foreach($lstIndex as $index)
          <option value="{{$index['id']}}"> {{$index['key_value']}} </option>
          @endforeach
        </select>

        <button type="submit" class="btn rounded-pill btn-primary waves-effect waves-light">
          <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Fetch
        </button>
      </form>
      <form class="mod-inline-50-percent" action="{{Route('loc.cacu_total', ['type' =>  config('common.BEER')]) }}" method="POST">
        @csrf
        <button type="submit" class="btn rounded-pill btn-warning waves-effect waves-light">
          <span class="tf-icons ri-checkbox-circle-line ri-16px me-1_5"></span>Caculator total
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
            <th>Type</th>
            <th>File_CH</th>
            <th>PHP</th>
            <th>JS</th>
            <th>CSS</th>
            <th>TPL</th>
            <th>Total</th>
            <th>Branch</th>
            <th>Notes</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @if(!empty($lstLocs))
          @php $counter = 1; @endphp
          @foreach($lstLocs as $parent)
           <tr class="{{$parent->id}} table-warning" id="{{$parent->id}}">
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
            <td>
              <select class="custom-select" id="exampleFormControlSelect1" name="sourceType" aria-label="Default select example">
                @foreach ($lstType as $key => $type)
                  <option value="{{$key}}" @if($parent->source_type == $key) selected="true" @endif> {{$type}} </option>
                @endforeach
              </select>
            </td>
            <td><input type="text" class="form-control" id="basic-default-fullname file_change" onchange="updateDateTime({{$parent->id}}, 1, {{$parent->source_type}})" name="fileChange" value="{{$parent->file_change}}"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" name="php" value="{{$parent->php}}"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" name="js" value="{{$parent->js}}"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" name="css" value="{{$parent->css}}"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" name="tpl" value="{{$parent->tpl}}"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" name="total" value="{{$parent->total}}"></td>
            <td>
              <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="branch"> {{$parent->branch}} </textarea>
            </td>
            <td>
              <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" name="notes"> {{$parent->notes}} </textarea>
            </td>

            <!-- action -->
            <td>
                        <div>
                            <!-- Gọi hàm callAjaxShowPopup với 3 tham số -->
                              <button type="button" class="btn btn-sm btn-outline-primary"
                                  onclick="callAjaxShowPopup('{{$parent->id}}','{{ $parent->number_task }}', 1 ,'{{  $parent->project_type }}', '{{  $parent->source_type }}')">
                                  <i class="ri-more-2-line"></i>
                              </button>

                        </div>
                    </td>

            <input type="hidden" style="display:none" name="typeUpdate" value="parent">
            <input type="hidden" style="display:none" name="id" value="{{$parent->id}}">
            <input type="hidden" style="display:none" name="numberTask" value="{{$parent->number_task}}">
          </tr>

          @php $counter++; @endphp
          {{-- if isset parent has child task render html --}}
          @if(!empty( $parent->childTasks))
          @foreach($parent->childTasks as $child)
           <tr class="child_{{$parent->id}}" id="{{$child->id}}">
            <td> {{$counter}} </td>
            <td><input type="text" class="form-control" id="basic-default-fullname" disabled value="{{$parent->number_task}}" name="parentNumber"></td>
            <td style="width: max-content;">{{$child->number_task}}<input type="text" class="form-control" id="basic-default-fullname" disabled value="{{$child->number_task}}" name="childNumber" style="display: none;"></td>
            <td>
              <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="status">
                @foreach ($lstStatus as $key => $status)
                <option value="{{$key}}" @if($child->status == $key) selected="true" @endif> {{ $status }} </option>
                @endforeach
              </select>
            </td>
            <td>
              <select class="custom-select" id="exampleFormControlSelect1" name="sourceType" aria-label="Default select example">
                @foreach ($lstType as $key => $type)
                <option value="{{$key}}" @if($child->source_type == $key) selected="true" @endif> {{$type}} </option>
                @endforeach
              </select>
            </td>
            <td><input type="text" class="form-control" id="basic-default-fullname file_change" onchange="updateDateTime({{$child->id}}, {{config('common.childTable')}}, {{$child->source_type}})" name="fileChange" value="{{$child->file_change}}"></td>
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
            <!-- action -->
  <td>
                            <div>
                                <!-- Gọi hàm callAjaxShowPopup với 3 tham số -->
                              <button type="button" class="btn btn-sm btn-outline-primary"
                                  onclick="callAjaxShowPopup('{{$child->id}}','{{ $child->number_task }}', 2 ,'{{  $child->project_type }}', '{{  $child->source_type }}')">
                                  <i class="ri-more-2-line"></i>
                              </button>

                            </div>
                        </td>
            <!-- action -->
            <input type="hidden" style="display:none" name="typeUpdate" value="child">
            <input type="hidden" style="display:none" name="id" value="{{$child->id}}">

            {{-- fix temp missing submit data --}}
            <input type="hidden" style="display:none" name="numberTask" value="{{$child->number_task}}">
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
</form> {{-- form sumary --}}

  @extends('layouts/modal_common')

<!--/ Hoverable Table rows -->

<!-- Modal for displaying history -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg mod-max-width-95-precent">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historyModalLabel">Task History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Task</th>
              <th>Status</th>
              <th>Type</th>
              <th>File Change</th>
              <th>PHP</th>
                <th>JS</th>
                <th>CSS</th>
                <th>TPL</th>
                <th>Total</th>
                <th>Created</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="historyTableBody">
              <!-- History data will be appended here -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@stop()
@section('js')
<script>
  function updateDateTime(id, isParent, sourceType) {
    $.ajax({
      url: 'update/runtime',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        id: id,
        isParent: isParent,
        sourceType: sourceType
      },
      success: function(response) {
        console.log(response);
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

    setTimeout(function() {
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
      const numberTask   = row.querySelector('[name="numberTask"]')?.value || '';
      const sourceType   = row.querySelector('[name="sourceType"]')?.value || '';

      const keyGroup = numberTask + '_' + sourceType;

      if (keyGroup) {
        // Group data
        data[keyGroup] = {
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
          numberTask,
          sourceType
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

      const phpInput = row.querySelector('input[name="php"]');
      const jsInput = row.querySelector('input[name="js"]');
      const cssInput = row.querySelector('input[name="css"]');
      const tplInput = row.querySelector('input[name="tpl"]');
      const totalInput = row.querySelector('input[name="total"]');

      function updateTotal() {
        const phpValue = parseInt(phpInput.value) || 0;
        const jsValue = parseInt(jsInput.value) || 0;
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

  function addTimeOut() {
    setTimeout(function() {
      $('#alert-container .alert').alert('close');
    }, 2000); // 2 giây
  }

  function updateTotal(row) {
    // Lấy các giá trị của các input cần thiết (php, js, css)
    let php = parseFloat(row.querySelector('input[name="php"]').value) || 0;
    let js  = parseFloat(row.querySelector('input[name="js"]').value) || 0;
    let css = parseFloat(row.querySelector('input[name="css"]').value) || 0;
    let tpl = parseFloat(row.querySelector('input[name="tpl"]').value) || 0;

    // Tính tổng
    let total = php + js + css + tpl;

    // Cập nhật giá trị vào ô input tổng
    row.querySelector('input[name="total"]').value = total.toFixed(2);
  }

  // Thêm sự kiện onchange cho các trường input
  document.querySelectorAll('input[name="php"], input[name="js"], input[name="css"], input[name="tpl"]').forEach(input => {
    input.addEventListener('input', function() {
      let row = this.closest('tr'); // Tìm dòng <tr> chứa input
      updateTotal(row);
    });
  });

  function getHistoryTask(isParent, numberTask, sourceType, idTaskUpdate) {
    $.ajax({
        url: '{{ route("loc.getHistory") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            isParent: isParent,
            numberTask: numberTask,
            sourceType: sourceType
        },
        success: function(response) {
            if (response.success) {
                let historyTableBody = $('#historyTableBody');
                historyTableBody.empty();

                response.data.forEach(task => {
                    let row = `
                        <tr>
                            <td>${task.number_task}</td>
                            <td>${task.status}</td>
                            <td>${task.source_type}</td>
                            <td>${task.file_change}</td>
                            <td>${task.php}</td>
                            <td>${task.js}</td>
                            <td>${task.css}</td>
                            <td>${task.tpl}</td>
                            <td>${task.total}</td>
                            <td>${new Date(task.created_at).toLocaleDateString('en-GB')}</td>
                       
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="editTask('${numberTask}', '${task.id}', '${sourceType}', '${isParent}', '${idTaskUpdate}')">Edit</button>
                            </td>
                        </tr>
                    `;
                    historyTableBody.append(row);
                });

                $('#historyModal').modal('show');
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
            var alertHtml = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Unexpected error occurred. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            $('#alert-container').html(alertHtml);
        }
    });
  }
  
  function editTask(trCurrent ,numberTaskUpdate, idTaskOld, sourceType, isParent, idTaskUpdate) {
    console.log('numberTaskUpdate', numberTaskUpdate);  

    $.ajax({
      url: '{{ route("loc.updateOldData") }}',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        numberTaskUpdate: numberTaskUpdate,
        idTaskOld: idTaskOld,
        sourceType: sourceType,
        isParent: isParent
      },
      success: function(response) {
        if (response.success) {

            $('#historyModal').modal('hide');
          
            var alertHtml = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              ${response.message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
            $('#alert-container').html(alertHtml);

            // Update the row with the new data
            let row = $(trCurrent).closest('tr');
            row.find('input[name="status"]').val(response.data.status);
            row.find('input[name="fileChange"]').val(response.data.file_change);
            row.find('input[name="php"]').val(response.data.php);
            row.find('input[name="js"]').val(response.data.js);
            row.find('input[name="css"]').val(response.data.css);
            row.find('input[name="tpl"]').val(response.data.tpl);
            row.find('input[name="total"]').val(response.data.total);
            row.find('textarea[name="branch"]').val(response.data.branch);
            row.find('textarea[name="notes"]').val(response.data.notes);
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
        var alertHtml = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Unexpected error occurred. Please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
        $('#alert-container').html(alertHtml);
      }
    })
  }


function callAjaxShowPopup(rowId ,number_task, isParent, project_type, source_type) {
  window.targetRowId = rowId;

    $.ajax({
        url: '{{ route("loc.getModal") }}',
        type: 'POST',
        data: {
            numberTask: number_task,
            isParent: isParent,
            projectType: project_type,
            sourceType: source_type,
            _token: '{{ csrf_token() }}',
        },
        
        success: function (response) {
        if (!response.success || !response.data.length) {
          mdb.Alert.getInstance(document.getElementById('ajaxErrorAlert')).show();
          return;
        }

        // Lấy dòng mới nhất (giả sử là cuối danh sách)
        const latest = response.data[response.data.length - 1];

        // ✅ Đổ dữ liệu tóm tắt vào phần info trên modal
        $('#getInfoList').html(`
            <li><strong>Number Task:</strong> ${latest.number_task}</li>
            <li><strong>Project Type:</strong> ${latest.project_type}</li>
            <li><strong>Source Type:</strong> ${latest.source_type}</li>
        `);

        // ✅ Đổ danh sách các bản ghi vào bảng chi tiết
        const rows = response.data.map(item => `
          <tr>
            <td>${item.status ?? ''}</td>
            <td>${item.file_change ?? ''}</td>
            <td>${item.php ?? ''}</td>
            <td>${item.total ?? ''}</td>
            <td>${item.notes ?? ''}</td>
            <td>${item.run_time ?? ''}</td>
            <td>
              <button class="btn btn-sm btn-outline-primary" onclick='copyRowDataFromModal(${JSON.stringify(item)})'>Copy</button>
            </td>
          </tr>
        `).join('');

        $('#detailDataTable').html(rows);

        // ✅ Hiện modal
        const modal = new bootstrap.Modal(document.getElementById('exLargeModal'));
        modal.show();
      },        
      error: function () {
            // ❌ Hiện alert nếu lỗi
         alert("err")
        }
    });
}

// Optional: Copy button
function copyRowData(btn) {
    const row = $(btn).closest('tr');
    const text = row.find('td:not(:last)').map(function () {
        return $(this).text().trim();
    }).get().join('\t');

    navigator.clipboard.writeText(text)
        .then(() => {
            alert('✅ Đã copy: ' + text);
        })
        .catch(() => {
            alert('❌ Không thể copy dữ liệu');
        });
}

function copyRowDataFromModal(childData) {
  // console.log('Copying data from modal:', childData);
    const $targetRow = $('tr#' + window.targetRowId);

    if (!$targetRow.length) {
        alert('Không tìm thấy dòng để cập nhật');
        return;
    }

    // Gán giá trị vào các input/textarea trong dòng đó
    $targetRow.find('input[name="fileChange"]').val(childData.file_change ?? '');
    $targetRow.find('input[name="php"]').val(childData.php ?? '');
    $targetRow.find('input[name="js"]').val(childData.js ?? '');
    $targetRow.find('input[name="css"]').val(childData.css ?? '');
    $targetRow.find('input[name="tpl"]').val(childData.tpl ?? '');
    $targetRow.find('input[name="total"]').val(childData.total ?? '');
    $targetRow.find('textarea[name="branch"]').val(childData.branch ?? '');
    $targetRow.find('textarea[name="notes"]').val('old - ' + childData.notes ?? '');
    $targetRow.find('select[name="status"]').val(childData.status ?? '');

     // ✅ Bỏ focus khỏi nút copy trước khi đóng modal
  document.activeElement?.blur();

  // ✅ Delay 1 chút rồi đóng modal để tránh lỗi aria-hidden
  setTimeout(() => {
    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('exLargeModal'));
    modalInstance.hide();
  }, 100); // 100ms là đủ
}

</script>
@stop