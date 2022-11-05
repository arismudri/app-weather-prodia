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
            <h6 class="m-0 font-weight-bold text-primary">Wethers Detail</h6>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-secondary mb-4" onclick="back()">
                Back
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" id="data-tbl" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Main</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $row)
                            <tr>
                                <td>{{ $row->weather_detail_id }}</td>
                                <td>{{ $row->main }}</td>
                                <td>{{ $row->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let urlBack = "{{ url('') }}";

        function back() {
            window.location.replace(urlBack);
        }
    </script>
@endsection
