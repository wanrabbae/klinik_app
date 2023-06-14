@extends('templating.template_with_sidebar')

@section('content')
    <h1>Data Pokok Pasien</h1>
    <div class="separator mb-3"></div>
    @if (auth()->user()->role != 'Dokter')
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreatePasien">Tambah</button>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-info p-2 my-2" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif
    <table id="datatable" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor Rekam Medis</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Usia</th>
                <th>Jumlah Transaksi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_patients as $pasien)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pasien->nama_pasien }}</td>
                    <td>{{ $pasien->nomor_rekam_medis }}</td>
                    <td>{{ $pasien->telepon }}</td>
                    <td>{{ $pasien->alamat }}</td>
                    <td>{{ explode(' ', $pasien->tgl_lahir)[0] }}</td>
                    <td>{{ $pasien->usia }}</td>
                    <td>0</td>
                    <td>
                        <a href="/pasien/preview/{{ $pasien->id }}" class="btn btn-sm btn-info">Preview</a>
                        @if (auth()->user()->role != 'Dokter')
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien{{ $pasien->id }}">Edit</button>
                            <a href="/pasien/delete/{{ $pasien->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>
                        @endif

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEditPasien{{ $pasien->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/pasien/update/{{ $pasien->id }}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group has-float-label mb-3">
                                                <label for="">Nama Pasien</label>
                                                <input class="form-control" value="{{ $pasien->nama_pasien }}" name="nama_pasien" type="text" required id="nama_pasien" />
                                            </div>

                                            <div class="form-group has-float-label mb-3">
                                                <label>Telepon</label>
                                                <input class="form-control" value="{{ $pasien->telepon }}" type="text" required placeholder="" name="telepon" />
                                            </div>

                                            <div class="form-group has-float-label mb-3">
                                                <label>Alamat</label>
                                                <input class="form-control" type="text" required placeholder="" value="{{ $pasien->alamat }}" name="alamat" />
                                            </div>

                                            <div class="form-group has-float-label mb-3">
                                                <label>Tanggal Lahir</label>
                                                <input class="form-control" type="date" placeholder="" value="{{ date($pasien->tgl_lahir) }}" name="tgl_lahir" />
                                            </div>

                                            <div class="form-group has-float-label mb-3">
                                                <label>Usia</label>
                                                <input class="form-control" value="{{ $pasien->usia }}" type="number" required placeholder="" name="usia" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor Rekam Medis</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Usia</th>
                <th>Jumlah Transaksi</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-end mt-3">
        <p>Total {{ $countData }} Pasien</p>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreatePasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/pasien" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group has-float-label mb-3">
                            <label for="">Nama Pasien</label>
                            <input class="form-control" name="nama_pasien" type="text" required id="nama_pasien" />
                        </div>

                        <div class="form-group has-float-label mb-3">
                            <label>Telepon</label>
                            <input class="form-control" type="text" required placeholder="" name="telepon" />
                        </div>

                        <div class="form-group has-float-label mb-3">
                            <label>Alamat</label>
                            <input class="form-control" type="text" required placeholder="" name="alamat" />
                        </div>

                        <div class="form-group has-float-label mb-3">
                            <label>Tanggal Lahir</label>
                            <input class="form-control" type="date" required placeholder="" name="tgl_lahir" />
                        </div>

                        <div class="form-group has-float-label mb-3">
                            <label>Usia</label>
                            <input class="form-control" type="number" required placeholder="" name="usia" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
