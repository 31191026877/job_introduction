@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route("admin.posts.create") }}">
                        Create
                    </a>
                    <label for="csv" class="btn btn-info mb-0">
                        Import CSV
                    </label>
                    <input type="file" name="csv" id="csv" class="d-none"
                           accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <nav class="float-right">
                        <ul class="pagination pagination-rounded mb-0" id="pagination">
                        </ul>
                    </nav>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-centered mb-0" id="table-data">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Location</th>
                            <th>Remotable</th>
                            <th>Is Part-time</th>
                            <th>Range salary</th>
                            <th>Date range</th>
                            <th>status</th>
                            <th>Is pinned</th>
                            <th>Created at</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $('select').select2();
            // crawl data
            $.ajax({
                url: '{{ route('api.posts') }}',
                dataType: 'json',
                data: {page: {{ request()->get('page') ?? 1 }}},
                success: function (response) {
                    response.data.data.forEach(function (each) {
                        let location = each.district + ' - ' + each.city;
                        let remotable = each.remotable ? 'x' : '';
                        let is_partime = each.is_partime ? 'x' : '';
                        let range_salary = (each.min_salary && each.max_salary) ? each.min_salary + '-' + each.max_salary : '';
                        let range_date = (each.start_date && each.end_date) ? each.start_date + '-' + each.end_date : '';
                        let is_pinned = each.is_pinned ? 'x' : '';
                        let created_at = convertDateToDateTime(each.created_at);
                        $('#table-data').append($('<tr>')
                            .append($('<td>').append(each.id))
                            .append($('<td>').append(each.job_title))
                            .append($('<td>').append(location))
                            .append($('<td>').append(remotable))
                            .append($('<td>').append(is_partime))
                            .append($('<td>').append(range_salary))
                            .append($('<td>').append(range_date))
                            .append($('<td>').append(each.status))
                            .append($('<td>').append(is_pinned))
                            .append($('<td>').append(created_at))
                        );
                    });
                    renderPagination(response.data.pagination);
                }, error: function (response) {
                    $.toast({
                        heading: 'Import Error',
                        text: response.responseJSON.message,
                        showHideTransition: 'slide',
                        position: 'bottom-right',
                        icon: 'error'
                    })
                }
            });
            $(document).on('click', '#pagination > li > a', function (event) {
                event.preventDefault();
                let page = $(this).text();
                let urlParams = new URLSearchParams(window.location.search);
                urlParams.set('page', page);
                window.location.search = urlParams;
            });
            $('#csv').change(function (event) {
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                $.ajax({
                    url: '{{ route('admin.posts.import_csv') }}',
                    type: 'POST',
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        response.data.forEach(function (each) {
                            $('#table-data').append($('<tr>')
                                .append($('<td>').append(each.id))
                                .append($('<td>').append(each.job_title))
                                .append($('<td>').append(each.location))
                                .append($('<td>').append(each.remotable))
                                .append($('<td>').append(each.is_partime))
                                .append($('<td>').append(each.range_salary))
                                .append($('<td>').append(each.range_date))
                                .append($('<td>').append(each.status))
                                .append($('<td>').append(each.is_pinned))
                                .append($('<td>').append(each.created_at))
                            );
                        });
                    }
                });
            });
        });
    </script>
@endpush
