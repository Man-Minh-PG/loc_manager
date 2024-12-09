@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 
 <div class="card">
  <form action="{{Route('loc.index', ['type' => 1])}}" method="GET">
    <input class="form-control" name="dateSearch" type="date" id="html5-date-input" style="width: 50%;"> 
    <button type="submit" class="btn btn-primary waves-effect waves-light" style="width: 50%;">
      <span class="tf-icons ri-search-2-line  ri-8px me-1_5"></span>Find
    </button>
  </form>

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
  
    {{-- <h5 class="card-header">REPORT - LOC [November] </h5> --}}
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
            <th>Execution time</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach ($lstParentlocs as $parentTask)
          <tr>
          
            <td><a target="_blank" href="https://project.lampart-vn.com/issues/{{$parentTask->number_task}}"> {{ $parentTask->number_task }} </a></td>
            <td>
              @if ($parentTask->status == config('common.new'))
                <span class="badge bg-label-warning rounded-pill">New</span>
              @elseif ($parentTask->status == config('common.inProgress'))
                <span class="badge bg-label-info rounded-pill">In Progress</span>
              @elseif ($parentTask->status == config('common.completed'))
                <span class="badge bg-label-success rounded-pill">Completed</span>
              @elseif ($parentTask->status == config('common.close'))
                <span class="badge bg-label-secondary rounded-pill">Close</span>
              @endif
            </td>
            <td> {{$parentTask->file_change}} File</td>
            <td> {{$parentTask->php}} </td>
            <td> {{$parentTask->js}} </td>
            <td> {{$parentTask->css}} </td>
            <td> {{$parentTask->tpl}} </td>
            <td> {{$parentTask->total}} </td>
            <td> 
              @if(!is_null($parentTask->run_time))
                {{$parentTask->run_time}}
              @else
                Updated....
              @endif
            </td>
            
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-more-2-line"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{Route('loc.edit', ['type' => 1, 'id_parent' => $parentTask->id])}}"
                    ><i class="ri-pencil-line me-1"></i> Edit</a
                  >
                  {{-- <a class="dropdown-item" href="javascript:void(0);"
                    ><i class="ri-delete-bin-6-line me-1"></i> Delete</a
                  > --}}
                  <a class="dropdown-item" href="{{Route('loc.detail', ['id_parent' => $parentTask->id])}}"
                    ><i class="ri-information-fill  me-1"></i> info</a
                  >
                  <a class="dropdown-item" href="javascript:void(0);"
                    ><i class="ri-delete-bin-6-line me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <!--/ Hoverable Table rows -->
@stop()