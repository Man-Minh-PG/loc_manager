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
        <h5 class="card-header">{{$monthName}} Work Report</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>STT</th>
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
                        <th>Compare</th>
                        <th>Branch</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php $counter = 1; @endphp
                    @foreach ($comparedData as $data)
                    @php
                    $parent = $data['parent'];
                    $parentDiff = $data['parent_diff'];
                    $childDiffs = $data['child_diffs'];
                    @endphp

                    {{-- Parent row --}}
                    <tr>
                        <td>{{ $counter }}</td>
                        <td style="color: rgb(140, 86, 255);"> {{ $parent->number_task }} </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="ri-vip-crown-line ri-10px text-primary me-2"></i>
                                <span>Parent</span>
                            </div>
                        </td>
                        <td></td>

                        {{-- Source --}}
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

                        {{-- Status --}}
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

                        {{-- Các cột kỹ thuật --}}
                        <td>{{ $parent->file_change }} File</td>
                        <td>{{ $parent->php }}</td>
                        <td>{{ $parent->js }}</td>
                        <td>{{ $parent->css }}</td>
                        <td>{{ $parent->tpl }}</td>

                        {{-- Tổng + Chênh lệch --}}
                        <td>{{ $parent->total }}</td>
                        <td>
                            @if($parentDiff !== null)
                            <span class="{{ $parentDiff == 0 ? '' : ($parentDiff > 0 ? 'text-success' : 'text-danger') }}">
                                {{ $parentDiff > 0 ? '+' : '' }}{{ $parentDiff }}
                            </span>
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        {{-- Branch & Notes --}}
                        <td style="max-width: 280px; word-break: break-word;">{{ $parent->branch }}</td>
                        <td style="max-width: 200px; word-break: break-word;">{{ $parent->notes }}</td>

                        @php $counter++; @endphp
                    </tr>

                    {{-- CHILDREN --}}
                    @foreach($parent->childTasks as $child)
                    @php
                    $childDiff = $childDiffs[$child->number_task] ?? null;
                    @endphp
                    <tr class="table-primary">
                        <td>{{ $counter }}</td>
                        <td style="color: rgb(140, 86, 255);">{{ $child->number_task }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="ri-heart-2-fill ri-12px text-success me-2"></i>
                                <span>Child</span>
                            </div>
                        </td>
                        <td>{{ $parent->number_task }}</td>

                        {{-- Source --}}
                        <td>
                            @if($child->source_type == config('common.Sys'))
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

                        {{-- Status --}}
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

                        <td>{{ $child->file_change }} File</td>
                        <td>{{ $child->php }}</td>
                        <td>{{ $child->js }}</td>
                        <td>{{ $child->css }}</td>
                        <td>{{ $child->tpl }}</td>

                        {{-- Tổng + Chênh lệch --}}
                        <td>{{ $child->total }}</td>
                        <td>
                            @if($childDiff && $childDiff['diff'] !== null)
                            <span class="{{ $childDiff['diff'] == 0 ? '' : ($childDiff['diff'] > 0 ? 'text-success' : 'text-danger') }}">
                                {{ $childDiff['diff'] > 0 ? '+' : '' }}{{ $childDiff['diff'] }}
                            </span>
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        <td style="max-width: 280px; word-break: break-word;">{{ $child->branch }}</td>
                        <td style="max-width: 200px; word-break: break-word;">{{ $child->notes }}</td>

                        @php $counter++; @endphp
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