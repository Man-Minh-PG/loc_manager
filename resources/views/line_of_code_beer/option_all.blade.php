@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <div class="col-md-12 mb-6">
 <div class="card">
  <form action="{{Route('loc.show', ['type' => 2])}}" method="GET">
    <input class="form-control" name="dateSearch" type="date" id="html5-date-input" style="width: 50%;"> 
    <button type="submit" class="btn btn-primary waves-effect waves-light" style="width: 50%;">
      <span class="tf-icons ri-search-2-line  ri-8px me-1_5"></span>Find
    </button>
  </form>

  </div>
</div>
<div class="col-md-12 mb-6">
    <div class="card">
        <h5 class="card-header">November Work Report</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Task</th>
                <th>Task type</th>
                <th style="padding-right: 0px; padding-left: 0px;">Child of task</th>
                <th>Source</th>
                <th>Status</th>
                <th>File_change</th>
                <th>PHP</th>
                <th>JS</th>
                <th>CSS</th>
                <th>TPL</th>
                <th>Sum</th>
                <th>Branchs</th>
                <th>Notes</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($lstLocs as $parent)
              <tr class="">
                <td><a href=""> {{ $parent->number_task }} </a></td>
                <td>
                  <div class="d-flex align-items-center">
                    <i class="ri-vip-crown-line ri-10px text-primary me-2"></i>
                    <span>Parent</span>
                  </div>
                </td>
                <td  style="padding-right: 0px; padding-left: 0px;"></td>
                {{-- different with PW --}}
                <td>
                    @if($parent->source_type == config('common.PW'))
                    <div class="d-flex align-items-center">
                      <i class="ri-shield-star-line  ri-13px text-danger me-2"></i>
                      <span>Sys</span>
                    </div>  
                    @else
                    <div class="d-flex align-items-center">
                      <i class="ri-shopping-basket-line  ri-13px text-warning me-2"></i>
                      <span>Ec</span>
                    </div>  
                    @endif
                </td>
                {{-- different with PW --}}
                <td>
                  @if ($parent->status == config('common.new'))
                    <span class="badge bg-label-warning rounded-pill">New</span>
                  @elseif ($parent->status == config('common.inProgress'))
                    <span class="badge bg-label-info rounded-pill">In Progress</span>
                  @elseif ($parent->status == config('common.completed'))
                    <span class="badge bg-label-success rounded-pill">Completed</span>
                  @elseif ($parent->status == config('common.close'))
                    <span class="badge bg-label-secondary rounded-pill">Close</span>
                  @endif
                </td>
                <td> {{ $parent->file_change}} File</td>
                <td> {{ $parent->php}} </td>
                <td> {{ $parent->js}} </td>
                <td> {{ $parent->css}} </td>
                <td> {{ $parent->tpl}} </td>
                <td> {{ $parent->total}} </td>
                <td> {{ $parent->branch}} </td>
                <td> {{ $parent->notes}} </td>
              </tr>
                @foreach ($parent->childTasks as $child)
                <tr class="table-primary"> 
                  <td><a href=""> {{ $child->number_task }} </a></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class=" ri-heart-2-fill ri-12px text-success me-2"></i>
                      <span>Child</span>
                    </div>
                  </td>
                  <td  style="padding-right: 0px; padding-left: 0px;"> {{$parent->number_task}} </td>
                  {{-- different with PW --}}
                  <td>
                    @if($parent->source_type == config('common.PW'))
                    <div class="d-flex align-items-center">
                      <i class="ri-shield-star-line  ri-13px text-danger me-2"></i>
                      <span>Sys</span>
                    </div>  
                    @else
                    <div class="d-flex align-items-center">
                      <i class="ri-shopping-basket-line  ri-13px text-warning me-2"></i>
                      <span>Ec</span>
                    </div>  
                    @endif
                  </td>
                  {{-- different with PW --}}
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
                  <td> {{ $child->file_change}} File</td>
                  <td> {{ $child->php}} </td>
                  <td> {{ $child->js}} </td>
                  <td> {{ $child->css}} </td>
                  <td> {{ $child->tpl}} </td>
                  <td> {{ $child->total}} </td>
                  <td> {{ $child->branch}} </td>
                  <td> {{ $child->notes}} </td>
                </tr>
                @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
</div>
  <!--/ Hoverable Table rows -->
@stop()