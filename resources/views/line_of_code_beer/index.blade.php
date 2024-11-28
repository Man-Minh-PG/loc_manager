@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <div class="card">
  <input class="form-control" type="dateSearch" id="html5-date-input" style="width: 50%;"> 
  <button type="button" class="btn btn-secondary waves-effect waves-light" style="width: 50%;">
    <span class="tf-icons ri-notification-4-line ri-8px me-1_5"></span>Find
  </button>
    {{-- <h5 class="card-header">REPORT - LOC [November] </h5> --}}
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Parent task</th>
            <th>Type</th>
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
            <td><a href="">#1989273</a></td>
            <td>Sys</td>
            <td>Done</td>
            <td>11 File</td>
            <td>97</td>
            <td>67</td>
            <td>32</td>
            <td>32</td>
            <td>132</td>
            <td>2024:11:22 11:22:11</td>
            {{-- <td>
              <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                <li
                  data-bs-toggle="tooltip"
                  data-popup="tooltip-custom"
                  data-bs-placement="top"
                  class="avatar avatar-xs pull-up"
                  title="Lilian Fuller">
                  <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                </li>
                <li
                  data-bs-toggle="tooltip"
                  data-popup="tooltip-custom"
                  data-bs-placement="top"
                  class="avatar avatar-xs pull-up"
                  title="Sophia Wilkerson">
                  <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                </li>
                <li
                  data-bs-toggle="tooltip"
                  data-popup="tooltip-custom"
                  data-bs-placement="top"
                  class="avatar avatar-xs pull-up"
                  title="Christina Parker">
                  <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                </li>
              </ul>
            </td> --}}
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-more-2-line"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{Route('loc.edit', ['type' => 2])}}"
                    ><i class="ri-pencil-line me-1"></i> Edit</a
                  >
                  {{-- <a class="dropdown-item" href="javascript:void(0);"
                    ><i class="ri-delete-bin-6-line me-1"></i> Delete</a
                  > --}}
                  <a class="dropdown-item" href="{{Route('loc.detail')}}"
                    ><i class="ri-information-fill  me-1"></i> info</a
                  >
                  <a class="dropdown-item" href="javascript:void(0);"
                    ><i class="ri-delete-bin-6-line me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!--/ Hoverable Table rows -->
@stop()