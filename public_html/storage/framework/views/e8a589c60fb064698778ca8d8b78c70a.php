<style>
    .inputRange:focus {}

    .inputRange {
        font-size: 15px;
        padding: 5px;
        border: none;
    }
</style>
<?php $__env->startSection('content'); ?>
    <h1>Data Pokok Tindakan</h1>
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
    <div class="mb-3">
        Range Biaya: <input type="number" class="inputRange" id="minFee" placeholder="minimal"> - <input type="number" class="inputRange" id="maxFee" placeholder="maksimal">
    </div>
    <table id="datatable" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tindakan</th>
                <th>Satuan</th>
                <th>Jasa Medis</th>
                <th>BHP</th>
                <th>Total Harga</th>
                <th>Biaya Lain</th>
                <th>Keterangan</th>
                <?php if(auth()->user()->role != 'Dokter'): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data_tindakans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tindakan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($tindakan->nama_tindakan); ?></td>
                    <td><?php echo e($tindakan->satuan); ?></td>
                    <td>Rp. <?php echo e(number_format($tindakan->jasa_medis, 0, ',', '.')); ?></td>
                    <td>Rp. <?php echo e(number_format($tindakan->bhp, 0, ',', '.')); ?></td>
                    <td>Rp. <?php echo e(number_format($tindakan->total_harga, 0, ',', '.')); ?></td>
                    <td>Rp. <?php echo e(number_format($tindakan->biaya_lain, 0, ',', '.')); ?></td>
                    <td><?php echo e($tindakan->keterangan); ?></td>
                    <?php if(auth()->user()->role != 'Dokter'): ?>
                        <td>
                            
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien<?php echo e($tindakan->id); ?>">Edit</button>
                            <a href="/tindakan/delete/<?php echo e($tindakan->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEditPasien<?php echo e($tindakan->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Tindakan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="/tindakan/update/<?php echo e($tindakan->id); ?>" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="form-group has-float-label mb-3">
                                                    <label for="">Nama Tindakan</label>
                                                    <input class="form-control" value="<?php echo e($tindakan->nama_tindakan); ?>" name="nama_tindakan" type="text" required id="nama_tinakan" />
                                                </div>

                                                <div class="form-group has-float-label mb-3">
                                                    <label>Satuan</label>
                                                    <input class="form-control" value="<?php echo e($tindakan->satuan); ?>" type="text" required placeholder="" name="satuan" />
                                                </div>

                                                <div class="form-group has-float-label mb-3">
                                                    <label>Jasa Medis</label>
                                                    <input class="form-control" type="text" required placeholder="" value="<?php echo e($tindakan->jasa_medis); ?>" name="jasa_medis" />
                                                </div>

                                                <div class="form-group has-float-label mb-3">
                                                    <label>BHP</label>
                                                    <input class="form-control" type="number" placeholder="" value="<?php echo e($tindakan->bhp); ?>" name="bhp" />
                                                </div>

                                                <div class="form-group has-float-label mb-3">
                                                    <label>Biaya Lain</label>
                                                    <input class="form-control" type="number" placeholder="" value="<?php echo e($tindakan->biaya_lain); ?>" name="biaya_lain" />
                                                </div>

                                                

                                                <div class="form-group has-float-label mb-3">
                                                    <label>Keterangan</label>
                                                    <input class="form-control" value="<?php echo e($tindakan->keterangan); ?>" type="text" required placeholder="" name="keterangan" />
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
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                <?php if(auth()->user()->role != 'Dokter'): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-end mt-3">
        <p>Total <?php echo e($countData); ?> Tindakan</p>
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
                    <?php echo csrf_field(); ?>
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

                        <div class="form-group has-float-label mb-3">
                            <label>Biaya Lain</label>
                            <input class="form-control" type="number" required placeholder="" name="biaya_lain" />
                        </div>
                        

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templating.template_with_sidebar', ['isActiveTindakan' => 'active'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1126019.cloudwaysapps.com/ajuyqjhjns/public_html/resources/views/tindakan/tindakan.blade.php ENDPATH**/ ?>