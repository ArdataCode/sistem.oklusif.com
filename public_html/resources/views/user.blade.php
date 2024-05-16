@extends('templating.template_with_sidebar', ['isActiveUser' => 'active'])
<style>
    .inputRange:focus {}

    .inputRange {
        font-size: 15px;
        padding: 5px;
        border: none;
    }
</style>
@section('content')
<h1>Data User</h1>
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
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <img src="/uploadedimages/{{ $user->image }}" alt="PROFIL" width="80">
            </td>
            <td>{{ $user->nama }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien{{ $user->id }}">Edit</button>
                <a href="/user/delete/{{ $user->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEditPasien{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/user/update/{{ $user->id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group has-float-label mb-3">
                                        <label for="">Nama</label>
                                        <input class="form-control" name="nama" type="text" required id="nama" value="{{$user->nama}}" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label for="">Foto Profil Baru</label>
                                        <input class="form-control" name="image" accept="image/png, image/jpeg, image/jpg" type="file" id="image" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Email</label>
                                        <input class="form-control" type="email" required placeholder="" name="email" value="{{$user->email}}" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Role</label>
                                        <select name="role" id="role" required class="form-control">
                                            <option value="Owner" {{$user->role == "Owner" ? 'selected' : ''}}>Owner</option>
                                            <option value="Admin" {{$user->role == "Admin" ? 'selected' : ''}}>Admin</option>
                                        </select>
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Password Baru</label>
                                        <input class="form-control" type="password" placeholder="" name="new_password" />
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
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>

<div class="d-flex justify-content-end mt-3">
    <p>Total {{ $countData }} User</p>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreatePasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/user" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group has-float-label mb-3">
                        <label for="">Nama</label>
                        <input class="form-control" name="nama" type="text" required id="nama" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label for="">Foto Profil</label>
                        <input class="form-control" name="image" accept="image/png, image/jpeg, image/jpg" type="file" required id="image" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Email</label>
                        <input class="form-control" type="email" required placeholder="" name="email" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Role</label>
                        <select name="role" id="role" required class="form-control">
                            <option value="Owner">Owner</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Password</label>
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
@endsection