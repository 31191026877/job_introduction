@extends('layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <lable>
                                Company
                            </lable>
                            <select name="company" class="form-control" id="select-company">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <lable>
                                language (*)
                            </lable>
                            <select name="language" multiple class="form-control" id="select-language">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>City (*)</label>
                                <select class="form-control" name="city" id='select-city'></select>
                            </div>
                            <div class="form-group col-6">
                                <label>District</label>
                                <select class="form-control" name="district" id='select-district'></select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label>Min Salary</label>
                                <input type="number" name="min_salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Max Salary</label>
                                <input type="number" name="max_salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Max Salary</label>
                                <select name="currency_salary" class="form-control">
                                    @foreach($currencies as $currency => $value)
                                        <option value="{{ $value }}">
                                            {{ $currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        async function loadDistrict() {
            $('#select-district').empty();
            const path = $("#select-city option:selected").data('path');
            const response = await fetch('{{ asset('locations/') }}' + path);
            const districts = await response.json();
            $.each(districts.district, function (index, each) {
                if (each.pre === 'Quận') {
                    $("#select-district").append(`
                    <option>
                        ${each.name}
                    </option>`);
                }
            })
        }

        $(document).ready(async function () {
            $("#select-city").select2();
            const response = await fetch('{{ asset('locations/index.json') }}');
            const cities = await response.json();
            $.each(cities, function (index, each) {
                $("#select-city").append(`
                <option data-path='${each.file_path}'>
                    ${index}
                </option>`)
            })
            $("#select-city").change(function () {
                loadDistrict();
            });
            $('#select-district').select2();
            loadDistrict();
            $("#select-company").select2({
                tags: true,
                ajax: {
                    url: ' {{ route('api.companies') }}',
                    data: function (params) {
                        var queryParameters = {
                            q: params.term
                        };

                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id,
                                }
                            })
                        };
                    },

                }
            });
            $("#select-language").select2({
                ajax: {
                    url: ' {{ route('api.languages') }}',
                    data: function (params) {
                        var queryParameters = {
                            q: params.term
                        };

                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id,
                                }
                            })
                        };
                    },

                }
            });
        });
    </script>
@endpush
