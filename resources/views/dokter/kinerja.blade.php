@extends('templating.template_with_sidebar')

@section('content')
    <h1>Laporan Kinerja Dokter</h1>
    <div class="separator mb-3"></div>
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="Pilih Dokter">Pilih Dokter</label>
                            <select name="dokter" id="dokter" class="form-control">
                                <option value="" selected>Pilih Dokter</option>
                                @foreach ($data_dokters as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="Pilih Dokter">Rentang Tanggal</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" class="form-control" placeholder="Tanggal Awal">
                                </div>

                                <div class="col-md-6">
                                    <input type="date" class="form-control" placeholder="Tanggal Akhir">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
