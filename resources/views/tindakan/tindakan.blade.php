@extends('templating.template_with_sidebar')

@section('content')
    <h1>Data Pokok Tindakan</h1>
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
    <table id="datatable" class="display nowrap p-3" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tindakan</th>
                <th>Satuan</th>
                <th>Jasa Medis</th>
                <th>BHP</th>
                <th>Total Harga</th>
                <th>Keterangan</th>
                @if (auth()->user()->role != 'Dokter')
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data_tindakans as $tindakan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tindakan->nama_tindakan }}</td>
                    <td>{{ $tindakan->satuan }}</td>
                    <td>Rp. {{ number_format($tindakan->jasa_medis, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($tindakan->bhp, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($tindakan->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $tindakan->keterangan }}</td>
                    @if (auth()->user()->role != 'Dokter')
                        <td>
                            {{-- <a href="/tindakan/preview/{{ $tindakan->id }}" class="btn btn-sm btn-info">Preview</a> --}}
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien{{ $tindakan->id }}">Edit</button>
                            <a href="/tindakan/delete/{{ $tindakan->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEditPasien{{ $tindakan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Tindakan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="/tindakan/update/{{ $tindakan->id }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group has-float-label mb-3">
                                                    <label for="">Nama Tindakan</label>
                                                    <input class="form-control" value="{{ $tindakan->nama_tindakan }}" name="nama_tindakan" type="text" required id="nama_tinakan" />
                                                </div>

                                                <div class="form-group has-float-label mb-3">
                                                    <label>Satuan</label>
                                                    <input class="form-control" value="{{ $tindakan->satuan }}" type="text" required placeholder="" name="satuan" />
                                                </div>

                                                <div class="form-group has-float-label mb-3">
                                                    <label>Jasa Medis</label>
                                                    <input class="form-control" type="text" required placeholder="" value="{{ $tindakan->jasa_medis }}" name="jasa_medis" />
                                                </div>

                                                <div class="form-group has-float-label mb-3">
                                                    <label>BHP</label>
                                                    <input class="form-control" type="number" placeholder="" value="{{ $tindakan->bhp }}" name="bhp" />
                                                </div>

                                                {{-- <div class="form-group has-float-label mb-3">
                                                <label>Total Harga</label>
                                                <input class="form-control" value="{{ $tindakan->total_harga }}" type="number" required placeholder="" name="total_harga" />
                                            </div> --}}

                                                <div class="form-group has-float-label mb-3">
                                                    <label>Keterangan</label>
                                                    <input class="form-control" value="{{ $tindakan->keterangan }}" type="text" required placeholder="" name="keterangan" />
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
                    @endif
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Nama Tindakan</th>
                <th>Satuan</th>
                <th>Jasa Medis</th>
                <th>BHP</th>
                <th>Total Harga</th>
                <th>Keterangan</th>
                @if (auth()->user()->role != 'Dokter')
                    <th>Action</th>
                @endif
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-end mt-3">
        <p>Total {{ $countData }} Tindakan</p>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreatePasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tindakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/tindakan" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group has-float-label mb-3">
                            <label for="">Nama Tindakan</label>
                            <input class="form-control" name="nama_tindakan" type="text" required id="nama_tindakan" />
                        </div>

                        <div class="form-group has-float-label mb-3">
                            <label>Satuan</label>
                            <input class="form-control" type="text" required placeholder="" name="satuan" />
                        </div>

                        <div class="form-group has-float-label mb-3">
                            <label>Jasa Medis</label>
                            <input class="form-control" type="number" required placeholder="" name="jasa_medis" />
                        </div>

                        <div class="form-group has-float-label mb-3">
                            <label>BHP</label>
                            <input class="form-control" type="number" required placeholder="" name="bhp" />
                        </div>
                        {{-- 
                        <div class="form-group has-float-label mb-3">
                            <label>Total Harga</label>
                            <input class="form-control" type="number" required placeholder="" name="total_harga" />
                        </div> --}}

                        <div class="form-group has-float-label mb-3">
                            <label>Keterangan</label>
                            <input class="form-control" type="text" required placeholder="" name="keterangan" />
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
