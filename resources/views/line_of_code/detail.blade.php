
@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <!-- <hr class="my-12" /> -->
 <div class="card">
  <h5 class="card-header">Info line of code task: #{{$lstLocDetail[0]->number_task}} [2024 - 11]</h5>

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
            <th>Branch</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <tr>
            {{-- <td><i class="ri-suitcase-2-line ri-22px text-danger me-4"></i><span>#191817</span></td> --}}
            <td><a href="#"> {{$lstLocDetail[0]->number_task}} </a></td>
            <td>
              @if ($lstLocDetail[0]->status == config('common.new'))
                <span class="badge bg-label-warning rounded-pill">New</span>
              @elseif ($lstLocDetail[0]->status == config('common.inProgress'))
                <span class="badge bg-label-info rounded-pill">In Progress</span>
              @elseif ($lstLocDetail[0]->status == config('common.completed'))
                <span class="badge bg-label-success rounded-pill">Completed</span>
              @elseif ($lstLocDetail[0]->status == config('common.close'))
                <span class="badge bg-label-secondary rounded-pill">Close</span>
              @endif
            </td>
            </td>
            <td> {{$lstLocDetail[0]->file_change}} File</td>
            <td> {{$lstLocDetail[0]->php}} </td>
            <td> {{$lstLocDetail[0]->js}} </td>
            <td> {{$lstLocDetail[0]->css}} </td>s
            <td> {{$lstLocDetail[0]->tpl}} </td>
            <td> {{$lstLocDetail[0]->total}} </td>
            <td> {{$lstLocDetail[0]->created_at}} </td>
            <td> {{$lstLocDetail[0]->branch}} </td>
            <td> {{$lstLocDetail[0]->notes}} </td>
          </tr>
        </tbody>

      </table>
      <hr class="my-12" />
      <!-- Config child table -->
      @if (isset($lstLocDetail[0]->childTasks))
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Child task</th>
            <th>Status</th>
            <th>File_change</th>
            <th>PHP</th>
            <th>JS</th>
            <th>CSS</th>
            <th>TPL</th>
            <th>Total</th>
            <th>Create at</th>
            <th>Branch</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach ($lstLocDetail[0]->childTasks as $child)
          <tr>
            {{-- <td><i class="ri-suitcase-2-line ri-22px text-danger me-4"></i><span>#191817</span></td> --}}
            <td><a href="#"> {{$child->number_task}} </a></td>
            <td>
              @if ($child->status == config('common.new'))
                <span class="badge bg-label-warning rounded-pill">New</span>
              @elseif ($child->status == config('common.inProgress'))
                <span class="badge bg-label-info rounded-pill">In Progress</span>
              @elseif ($child->status == config('common.completed'))
                <span class="badge bg-label-success rounded-pill">Completed</span>
              @elseif ($child->status == config('common.close'))
                <span class="badge bg-label-secondary rounded-pill">Close</span>
              @endif
            </td>
            <td> {{$child->file_change}} File</td>
            <td> {{$child->php}} </td>
            <td> {{$child->js}} </td>
            <td> {{$child->css}} </td>
            <td> {{$child->tpl}} </td>
            <td> {{$child->total}} </td>
            <td> {{$child->branch}} </td>
            <td> {{$child->notes}} </td>
          </tr>
          @endforeach
        </tbody>
                     
      
      </table>
      @endif
      <!-- Config child table -->
    </div>
  </div>
  <!--/ Hoverable Table rows -->

@stop()