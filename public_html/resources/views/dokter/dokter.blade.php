@extends('templating.template_with_sidebar', ['isActiveDokter' => 'active'])

@section('content')
<h1>Data Pokok Dokter</h1>
<div class="separator mb-3"></div>
<div class="d-flex justify-content-end">
    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreatePasien">Tambah</button>
</div>
@if (session()->has('success'))
<div class="alert alert-info p-2 my-2" role="alert">
    {{ session()->get('success') }}
</div>
@endif
<table id="datatable" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Dokter</th>
            <th>Email</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
            <th>Total Transaksi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_dokters as $dokter)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <img src="/uploadedimages/{{ $dokter->image }}" alt="PROFIL" width="80">
            </td>
            <td>{{ $dokter->nama }}</td>
            <td>{{ $dokter->email }}</td>
            <td>{{ $dokter->telepon }}</td>
            <td>{{ $dokter->alamat }}</td>
            <td>{{ explode(' ', $dokter->tgl_lahir)[0] }}</td>
            <td>{{ $dokter->usia }}</td>
            <td>{{ count($dokter->transaksi) }}</td>
            <td>
                {{-- <a href="/dokter/preview/{{ $dokter->id }}" class="btn btn-sm btn-info">Preview</a> --}}
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien{{ $dokter->id }}">Edit</button>
                <a href="/dokter/delete/{{ $dokter->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEditPasien{{ $dokter->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Dokter</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/dokter/update/{{ $dokter->id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group has-float-label mb-3">
                                        <label for="">Nama Dokter</label>
                                        <input class="form-control" value="{{ $dokter->nama }}" name="nama_dokter" type="text" required id="nama_dokter" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label for="">Foto Profil Baru</label>
                                        <input class="form-control" name="image" accept="image/png, image/jpeg, image/jpg" type="file" id="image" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Telepon</label>
                                        <input class="form-control" value="{{ $dokter->telepon }}" type="text" required placeholder="" name="telepon" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Email</label>
                                        <input class="form-control" type="email" required placeholder="" value="{{ $dokter->email }}" name="email" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Alamat</label>
                                        <input class="form-control" type="text" required placeholder="" value="{{ $dokter->alamat }}" name="alamat" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Tanggal Lahir</label>
                                        <input class="form-control" value="{{ $dokter->tgl_lahir }}" id="born-dateEdit" onchange="calculateAgeEdit()" type="date" placeholder="" name="tgl_lahir" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Usia</label>
                                        <input class="form-control" id="ageEdit" value="{{ $dokter->usia }}" type="number" required placeholder="" name="usia" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Password Login Baru</label>
                                        <input class="form-control" type="password" placeholder="" name="password" />
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
            <th>Nama Dokter</th>
            <th>Email</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
            <th>Total Transaksi</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>

<div class="d-flex justify-content-end mt-3">
    <p>Total {{ $countData }} Dokter</p>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreatePasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Dokter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/dokter" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group has-float-label mb-3">
                        <label for="">Nama Dokter</label>
                        <input class="form-control" name="nama_dokter" type="text" required id="nama_dokter" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label for="">Foto Profil</label>
                        <input class="form-control" name="image" accept="image/png, image/jpeg, image/jpg" type="file" required id="image" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Telepon</label>
                        <input class="form-control" type="text" required placeholder="" name="telepon" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Email</label>
                        <input class="form-control" type="email" required placeholder="" name="email" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Alamat</label>
                        <input class="form-control" type="text" required placeholder="" name="alamat" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Tanggal Lahir</label>
                        <input class="form-control" type="date" id="born-date" onchange="calculateAge()" required placeholder="" name="tgl_lahir" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Usia</label>
                        <input class="form-control" id="age" type="number" required placeholder="" name="usia" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Password Login</label>
                        <input class="form-control" type="password" required placeholder="" name="password" />
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

<script>
    function calculateAge() {
        const bornDateInput = document.getElementById('born-date');
        const ageInput = document.getElementById('age');

        // Get the user's inputted birth date
        const bornDate = new Date(bornDateInput.value);

        // Calculate the age based on the current date
        const currentDate = new Date();
        const age = currentDate.getFullYear() - bornDate.getFullYear();

        // Set the calculated age as the value of the age input field
        ageInput.value = age;
    }

    function calculateAgeEdit() {
        const bornDateInput = document.getElementById('born-dateEdit');
        const ageInput = document.getElementById('ageEdit');

        // Get the user's inputted birth date
        const bornDate = new Date(bornDateInput.value);

        // Calculate the age based on the current date
        const currentDate = new Date();
        const age = currentDate.getFullYear() - bornDate.getFullYear();

        // Set the calculated age as the value of the age input field
        ageInput.value = age;
    }
</script>
@endsection