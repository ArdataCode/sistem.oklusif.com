<style>
    .inputRange:focus {}

    .inputRange {
        font-size: 15px;
        padding: 5px;
        border: none;
    }
</style>
<?php $__env->startSection('content'); ?>
<h1>Data User</h1>
<div class="separator mb-3"></div>
<div class="d-flex justify-content-end">
    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreatePasien">Tambah</button>
</div>
<?php if(session()->has('success')): ?>
<div class="alert alert-info p-2 my-2" role="alert">
    <?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>
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
        <?php $__currentLoopData = $data_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td>
                <img src="/uploadedimages/<?php echo e($user->image); ?>" alt="PROFIL" width="80">
            </td>
            <td><?php echo e($user->nama); ?></td>
            <td><?php echo e($user->email); ?></td>
            <td><?php echo e($user->role); ?></td>
            <td>
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien<?php echo e($user->id); ?>">Edit</button>
                <a href="/user/delete/<?php echo e($user->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEditPasien<?php echo e($user->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/user/update/<?php echo e($user->id); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="modal-body">
                                    <div class="form-group has-float-label mb-3">
                                        <label for="">Nama</label>
                                        <input class="form-control" name="nama" type="text" required id="nama" value="<?php echo e($user->nama); ?>" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label for="">Foto Profil Baru</label>
                                        <input class="form-control" name="image" accept="image/png, image/jpeg, image/jpg" type="file" id="image" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Email</label>
                                        <input class="form-control" type="email" required placeholder="" name="email" value="<?php echo e($user->email); ?>" />
                                    </div>

                                    <div class="form-group has-float-label mb-3">
                                        <label>Role</label>
                                        <select name="role" id="role" required class="form-control">
                                            <option value="Owner" <?php echo e($user->role == "Owner" ? 'selected' : ''); ?>>Owner</option>
                                            <option value="Admin" <?php echo e($user->role == "Admin" ? 'selected' : ''); ?>>Admin</option>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
    <p>Total <?php echo e($countData); ?> User</p>
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
                <?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templating.template_with_sidebar', ['isActiveUser' => 'active'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u726706882/domains/sistem.oklusif.com/public_html/resources/views/user.blade.php ENDPATH**/ ?>