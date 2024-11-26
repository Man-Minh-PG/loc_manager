
@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <hr class="my-12" />
 <div class="card">
    <h5 class="card-header">REPORT - LOC [November] </h5>
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
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <tr>
            {{-- <td><i class="ri-suitcase-2-line ri-22px text-danger me-4"></i><span>#191817</span></td> --}}
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="#1989273"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="Done"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="11 File"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="97"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="67"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="32"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="32"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="132"></td>
            <td><input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="2024:11:22 11:22:11"></td>

            <hr class="my-12" />



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
                  <a class="dropdown-item" href="javascript:void(0);"
                    ><i class="ri-pencil-line me-1"></i> Edit</a
                  >
                  {{-- <a class="dropdown-item" href="javascript:void(0);"
                    ><i class="ri-delete-bin-6-line me-1"></i> Delete</a
                  > --}}
                  <a class="dropdown-item" href="javascript:void(0);"
                    ><i class="ri-information-fill  me-1"></i> info</a
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

 <!-- Config child table -->
 
 <!-- Config child table -->

@stop()