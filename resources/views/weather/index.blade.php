<!-- Menghubungkan dengan view template master -->
@extends('master')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Halaman Tentang')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Wethers Data</h6>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-4" id="btn-load">
                Load New Data
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" id="data-tbl" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Timezone</th>
                            <th>Pressure</th>
                            <th>Humidity</th>
                            <th>Wind Speed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>
        let urlLogin = "{{ url('/login-view') }}";
        let urlData = "{{ url('/api/weather/get/datatable') }}";
        let urlDetail = "{{ url('/weather/detail-view') }}";
        let myDataTable = $('#data-tbl');
        let myBtnLoad = $('#btn-load');

        $(document).ready(function() {

            myDataTable.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: urlData,
                    headers,
                    error: err => {
                        window.location.replace(urlLogin);
                    }
                },
                columns: [{
                        name: 'lat',
                        data: 'lat',
                    },
                    {
                        name: 'lon',
                        data: 'lon',
                    },
                    {
                        name: 'timezone',
                        data: 'timezone',
                    },
                    {
                        name: 'pressure',
                        data: 'pressure',
                    },
                    {
                        name: 'humidity',
                        data: 'humidity',
                    },
                    {
                        name: 'wind_speed',
                        data: 'wind_speed',
                    },
                    {
                        name: 'action',
                        data: 'id',
                        render: (data, type, row, meta) => {
                            return `<a href="${urlDetail}/${data}"
                                        class="btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>`;
                        }
                    }
                ],
                "initComplete": function(settings, json) {
                    myBtnLoad.click(() => {
                        $.ajax({
                            method: "POST",
                            url: "{{ url('/api/weather') }}",
                            headers,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                myDataTable.DataTable().ajax.reload()
                            },
                        });
                    });
                }
            });
        });
    </script>
@endsection
