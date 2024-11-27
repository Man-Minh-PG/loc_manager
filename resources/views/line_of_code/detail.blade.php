
@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <!-- <hr class="my-12" /> -->
 <div class="card">
  <h5 class="card-header">Info line of code task: #111 [2024 - 11]</h5>

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
            <td><a href="#">#1989273</a></td>
            <td>Done</td>
            <td>11 File</td>
            <td>97</td>
            <td>67</td>
            <td>32</td>
            <td>32</td>
            <td>122</td>
            <td>2024:11:22 11:22:11</td>
            <td>Branch 123</td>
            <td>Note 123</td>
          </tr>
        </tbody>

      </table>
      <hr class="my-12" />
      <!-- Config child table -->
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
          <tr>
            {{-- <td><i class="ri-suitcase-2-line ri-22px text-danger me-4"></i><span>#191817</span></td> --}}
            <td><a href="#">#1989273</a></td>
            <td>Done</td>
            <td>11 File</td>
            <td>97</td>
            <td>67</td>
            <td>32</td>
            <td>32</td>
            <td>122</td>
            <td>2024:11:22 11:22:11</td>
            <td>Branch</td>
            <td>Note 123</td>
          </tr>
        </tbody>
                     
      
      </table>
      <!-- Config child table -->
    </div>
  </div>
  <!--/ Hoverable Table rows -->

@stop()