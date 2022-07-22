@extends('layouts.app')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daily Report</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Content Header -->

    <!-- content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- Filters -->
                            <div class="row">
                                <!-- From Filter -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>From:</strong></label>
                                        <div class="input-group date" id="datetimepickerFrom"
                                             data-target-input="nearest">
                                            <input type="text" id="fromId" class="form-control datetimepicker-input"
                                                   data-target="#datetimepickerFrom"/>
                                            <div class="input-group-append" data-target="#datetimepickerFrom"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.From Filter -->

                                <!-- To Filter -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>To:</strong></label>
                                        <div class="input-group date" id="datetimepickerTo" data-target-input="nearest">
                                            <input type="text" id="toId" class="form-control datetimepicker-input"
                                                   data-target="#datetimepickerTo"/>
                                            <div class="input-group-append" data-target="#datetimepickerTo"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.To Filter -->

                                <!-- Company Filter -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>Company:</strong></label>
                                        <select id='companyId' class="form-control">
                                            <option value="0">--Select Company--</option>
                                            @foreach($company as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /.Company Filter -->

                                <!-- Country Filter -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>Country:</strong></label>
                                        <select id='countryId' class="form-control">
                                            <option value="0">--Select Country--</option>
                                            @foreach($country as $item)
                                                <option value="{{$item->id}}">{{$item->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /.Country Filter -->
                            </div>
                            <!-- /.Filters -->
                        </div>

                        <div class="card-body">
                            <!-- Monthly Report Table -->
                            <div class="table-responsive">
                                <table id="dailyReportTable" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Day</th>
                                        <th>Country</th>
                                        <th>Number of tests</th>
                                        <th>Number of fails</th>
                                        <th>Connection Score</th>
                                        <th>PDD Score</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Company</th>
                                        <th>Day</th>
                                        <th>Country</th>
                                        <th>Number of tests</th>
                                        <th>Number of fails</th>
                                        <th>Connection Score</th>
                                        <th>PDD Score</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.Monthly Report Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(function () {
            /* Initialize datetime picker plugin for From input */
            $('#datetimepickerFrom').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            /* Initialize datetime picker plugin for To input */
            $('#datetimepickerTo').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            /* Initialize select2 plugin for company select input and set default value to '0' */
            $('#companyId').select2({
                placeholder: "Select a company",
                allowClear: true,
                val: null
            }).select2("val", 0);

            /* Initialize select2 plugin for country select input and set default value to '0' */
            $('#countryId').select2({
                placeholder: "Select a country",
                allowClear: true
            }).select2("val", 0);
        });

        /* Initialize datatable plugin for daily report table */
        var dailyReportTable = $('#dailyReportTable').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 20,
            // responsive: true,
            order: [[1, 'desc']],
            "sDom": 'Rfrtlip',
            "ajax": {
                url: "{{route('reports.dailyReport')}}",
                type: 'GET',
                data: function (d) {
                    d.company = $('#companyId').val();
                    d.country = $('#countryId').val();
                    d.from = $('#fromId').val();
                    d.to = $('#toId').val();
                }
            },
            columns: [
                {data: 'company_name', className: 'text-left', name: 'company_name'},
                {data: 'day', className: 'text-center', name: 'day'},
                {data: 'country_name', className: 'text-left', name: 'country_name'},
                {data: 'number_of_tests', className: 'text-right', name: 'number_of_tests'},
                {data: 'number_of_fails', className: 'text-right', name: 'number_of_fails'},
                {data: 'connection_score', className: 'text-center', name: 'connection_score'},
                {data: 'pdd_score', className: 'text-center', name: 'pdd_score'},
            ]
        });

        /* Reloads the table data when country select box value changes */
        $('#countryId').change(function () {
            dailyReportTable.draw();
        });

        /* Reloads the table data when company select box value changes */
        $('#companyId').change(function () {
            dailyReportTable.draw();
        });

        /* Reloads the table data when From picker value changes */
        $('#datetimepickerFrom').on("change.datetimepicker", function () {
            dailyReportTable.draw();
        });

        /* Reloads the table data when To picker value changes */
        $('#datetimepickerTo').on("change.datetimepicker", function () {
            dailyReportTable.draw();
        });
    </script>
@endpush
