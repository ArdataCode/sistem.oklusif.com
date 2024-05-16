<?php $__env->startSection('content'); ?>
<h1>Data Pokok Pasien</h1>
<div class="separator mb-3"></div>
<?php if(auth()->user()->role != 'Dokter'): ?>
<div class="d-flex justify-content-end">
    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreatePasien">Tambah</button>
</div>
<?php endif; ?>
<?php if(session()->has('success')): ?>
<div class="alert alert-info p-2 my-2" role="alert">
    <?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>
<table id="table_patient" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Nomor Rekam Medis</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
            <th>Jumlah Transaksi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        
        <?php $__currentLoopData = $data_patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pasien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td><?php echo e($pasien->nama_pasien); ?></td>
            <td><?php echo e($pasien->nomor_rekam_medis); ?></td>
            <td><?php echo e($pasien->telepon); ?></td>
            <td><?php echo e($pasien->alamat); ?></td>
            <td><?php echo e($pasien->tempat_lahir); ?></td>
            <td><?php echo e(explode(' ', $pasien->tgl_lahir)[0]); ?></td>
            <td><?php echo e($pasien->usia); ?></td>
            <td><?php echo e(count($pasien->transactions)); ?></td>
            <td>
                <a href="/preview_pasien?id=<?php echo e($pasien->id); ?>" class="btn btn-sm btn-info">Preview</a>
                <?php if(auth()->user()->role != 'Dokter'): ?>
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien<?php echo e($pasien->id); ?>">Edit</button>
                <a href="/pasien/delete/<?php echo e($pasien->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>
                <?php endif; ?>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEditPasien<?php echo e($pasien->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Pasien</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/pasien/update/<?php echo e($pasien->id); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="modal-body">
                                    <div class="form-group has-float-label mb-3">
                                        <label for="">Nama Pasien</label>
                                        <input class="form-control" value="<?php echo e($pasien->nama_pasien); ?>" name="nama_pasien" type="text" required id="nama_pasien" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Telepon</label>
                                        <input class="form-control" value="<?php echo e($pasien->telepon); ?>" type="text" required placeholder="" name="telepon" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Alamat</label>
                                        <input class="form-control" type="text" required placeholder="" value="<?php echo e($pasien->alamat); ?>" name="alamat" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Tempat Lahir</label>
                                        <input class="form-control" type="text" id="born-place" required placeholder="" name="tempat_lahir" value="<?php echo e($pasien->tempat_lahir); ?>" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Tanggal Lahir</label>
                                        <input class="form-control" id="born-dateEdit" type="date" onchange="calculateAgeEdit()" placeholder="" value="<?php echo e(date('d-m-Y', strtotime($pasien->tgl_lahir))); ?>" name="tgl_lahir" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Usia</label>
                                        <input class="form-control" value="<?php echo e($pasien->usia); ?>" type="number" id="ageEdit" required placeholder="" name="usia" />
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Nomor Rekam Medis</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
            <th>Jumlah Transaksi</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>

<div class="d-flex justify-content-end mt-3">
    <p>Total <?php echo e($countData); ?> Pasien</p>
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
                <?php echo csrf_field(); ?>
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
                        <label>Tempat Lahir</label>
                        <input class="form-control" type="text" id="born-place" required placeholder="" name="tempat_lahir" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Tanggal Lahir</label>
                        <input class="form-control" type="date" id="born-date" onchange="calculateAge()" required placeholder="" name="tgl_lahir" />
                    </div>

                    <div class="form-group has-float-label mb-3">
                        <label>Usia</label>
                        <input class="form-control" type="number" id="age" required placeholder="" name="usia" />
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templating.template_with_sidebar', ['isActivePasien' => 'active'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1126019.cloudwaysapps.com/ajuyqjhjns/public_html/resources/views/pasien/pasien.blade.php ENDPATH**/ ?>