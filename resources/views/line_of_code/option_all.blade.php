@extends('layouts/admin_layout')
@section('main')
 <!-- Hoverable Table rows -->
 <div class="col-md-12 mb-6">
 <div class="card">
    <div class="col-md-6">
    <input class="form-control" type="date" id="html5-date-input">
    {{-- <h5 class="card-header">REPORT - LOC [November] </h5> --}}
    </div>

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
                <th>File_change</th>
                <th>PHP</th>
                <th>JS</th>
                <th>CSS</th>
                <th>TPL</th>
                <th>Sum</th>
                <th>Notes</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr class="table-light">
                <td>(Parent) - <a href="">1111</a></td>
                <td>11 File</td>
                <td>99</td>
                <td>99</td>
                <td>99</td>
                <td>99</td>
                <th>111</th>
                <td>Note 123</td>
              </tr>
              <tr class="table-primary">
                <td>Child - <a href="">1111</a></td>
                <td>11 File</td>
                <td>99</td>
                <td>99</td>
                <td>99</td>
                <td>99</td>
                <th>111</th>
                <td>Note 123</td>
              </tr>
              <tr class="table-primary">
                <td>Child - <a href="">1111</a></td>
                <td>11 File</td>
                <td>99</td>
                <td>99</td>
                <td>99</td>
                <td>99</td>
                <th>111</th>
                <td>Note 123</td>
              </tr>
              <tr class="table-light">
                <td>(Parent) - <a href="">1111</a></td>
                <td>11 File</td>
                <td>99</td>
                <td>99</td>
                <td>99</td>
                <td>99</td>
                <th>111</th>
                <td>Note 123</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
</div>
  <!--/ Hoverable Table rows -->
@stop()