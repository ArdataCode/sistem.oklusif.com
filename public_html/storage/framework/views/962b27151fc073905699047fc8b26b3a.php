<style>
    /* table, */
    th,
    td {
        border: 1px solid black;
        text-align: center;
        padding: 10px;
    }
</style>
<?php $__env->startSection('content'); ?>
<h1>Preview Transaksi <?php echo e($transaction->nomor_transaksi); ?></h1>
<div class="separator mb-5"></div>

<?php if(session()->has('success')): ?>
<div class="alert alert-info p-2 my-2" role="alert">
    <?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>

<?php if(session()->has('error')): ?>
<div class="alert alert-danger p-2 my-2" role="alert">
    <?php echo e(session()->get('error')); ?>

</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <p class="text-lg" style="font-size: 18px;">Nomor Transaksi: <strong><?php echo e($transaction->nomor_transaksi); ?></strong></p>
        <p class="text-lg" style="font-size: 18px;">Tanggal Transaksi: <strong><?php echo e($transaction->created_at->format('d-F-Y')); ?></strong></p>
        <p class="text-lg" style="font-size: 18px;">Nama Pasien: <strong><?php echo e($transaction->pasien->nama_pasien); ?></strong></p>
        <p class="text-lg" style="font-size: 18px;">No Rekam Medis: <strong><?php echo e($transaction->pasien->nomor_rekam_medis); ?></strong></p>
        <p class="text-lg" style="font-size: 18px;">Alamat: <strong><?php echo e($transaction->pasien->alamat); ?></strong></p>
        <p class="text-lg" style="font-size: 18px;">No. Telp: <strong><?php echo e($transaction->pasien->telepon); ?></strong></p>
        <p class="text-lg" style="font-size: 18px;">Transaksi ke: <strong><?php echo e($transaction->id); ?></strong></p>
        <p class="text-lg" style="font-size: 18px;">Dokter Yang Menangani: <strong><?php echo e($transaction->dokter->nama); ?></strong></p>

        <form action="/tindakan/update-keterangan/<?php echo e($transaction->id); ?>" method="post">
            <?php echo csrf_field(); ?>
            <p class="text-lg" style="font-size: 18px;">Keterangan Dokter: </p>
            <textarea name="keterangan" id="keterangan" rows="2" class="form-control mb-2"><?php echo e($transaction->keterangan); ?></textarea>
            <button class="btn btn-sm btn-primary mx-auto" type="submit">Ubah Keterangan</button>
        </form>

        

        <div class="mt-5">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <p class="text-lg" style="font-size: 18px;" class="text-muted">List Tindakan: </p>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalCreateTindakan">Tambah Tindakan</button>
            </div>

            <table border="1" cellspacing="0" style="width: 100%; text-align: center;">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Qty</th>
                        <th>Biaya</th>
                        <th>Disc (%)</th>
                        <th>Sub Total</th>
                        <th>Biaya Lain</th>
                        <th>Ket</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $transaction->transaction_tindak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tindakan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($tindakan->tindakan->nama_tindakan); ?></td>
                        <td><?php echo e($tindakan->quantity); ?></td>
                        <td><?php echo e(number_format($tindakan->biaya, 0, ',', '.')); ?></td>
                        <td><?php echo e($tindakan->discount); ?></td>
                        <td><?php echo e(number_format($tindakan->subtotal, 0, ',', '.')); ?></td>
                        <td><?php echo e(number_format($tindakan->biayalain, 0, ',', '.')); ?></td>
                        <td><?php echo e($tindakan->keteranganlain); ?></td>
                        <td>
                            <button class="btn btn-info" data-toggle="modal" data-target="#modalEditTindakan<?php echo e($tindakan->id); ?>">Edit</button>
                            <a href="/transaction/tindakan/delete/<?php echo e($tindakan->id); ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>


                            <div class="modal fade" id="modalEditTindakan<?php echo e($tindakan->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Tindakan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="/transaction/tindakan/edit" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <input type="hidden" name="tindakan_id" value="<?php echo e($tindakan->id); ?>">
                                                <div class="form-group mb-3">
                                                    <label for="" style="text-align: left;">Quantity</label>
                                                    <input class="form-control" name="quantity" type="number" required id="quantityEdit" value="<?php echo e($tindakan->quantity); ?>" />
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="">Diskon (%)</label>
                                                    <input class="form-control" name="diskon" type="number" required id="diskonEdit" value="<?php echo e($tindakan->discount); ?>" />
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="">Biaya Lain</label>
                                                    <input class="form-control" name="biaya_lain" type="text" required id="biaya_lainEdit" value="<?php echo e($tindakan->biayalain); ?>" />
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="">Keterangan</label>
                                                    <input class="form-control" name="keterangan_lain" type="text" required id="keterangan_lainEdit" value="<?php echo e($tindakan->keteranganlain); ?>" />
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
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td colspan="4">Total</td>
                        <td colspan="2">
                            Rp. <?php echo e(number_format($transaction->transaction_tindak->sum('subtotal'), 0, ",", ".")); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreateTindakan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/transaction/tindakan" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="trx_id" value="<?php echo e($transaction->id); ?>">
                    <div class="form-group has-float-label mb-3">
                        <label for="">Nama Tindakan</label>
                        <select onchange="assignValueTindakan(this)" required class="form-control" name="tindakan_id" id="tindakan_id">
                            <option value="" selected>Pilih Tindakan</option>
                            <?php $__currentLoopData = $data_tindakan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>-<?php echo e($item->nama_tindakan); ?>-<?php echo e($item->total_harga); ?>-<?php echo e($item->biaya_lain); ?>-<?php echo e($item->keterangan); ?>"><?php echo e($item->nama_tindakan); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group has-float-label mb-3">
                        <label for="">Biaya</label>
                        <input class="form-control" name="biaya" type="number" required id="biaya" />
                    </div>
                    <div class="form-group has-float-label mb-3">
                        <label for="">Quantity</label>
                        <input class="form-control" name="quantity" type="number" required id="quantity" />
                    </div>
                    <div class="form-group has-float-label mb-3">
                        <label for="">Diskon (%)</label>
                        <input class="form-control" name="diskon" type="number" required id="diskon" />
                    </div>
                    <div class="form-group has-float-label mb-3">
                        <label for="">Biaya Lain</label>
                        <input class="form-control" name="biaya_lain" type="number" required id="biaya_lain" />
                    </div>
                    <div class="form-group has-float-label mb-3">
                        <label for="">Keterangan</label>
                        <input class="form-control" name="keterangan_lain" type="text" required id="keterangan_lain" />
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
    const biaya = document.getElementById('biaya')
    const biaya_lain = document.getElementById('biaya_lain')
    const keterangan_lain = document.getElementById('keterangan_lain')

    function assignValueTindakan(selectElement) {
        console.log(selectElement.value);
        biaya.value = selectElement.value.split("-")[2]
        biaya_lain.value = selectElement.value.split("-")[3]
        // keterangan_lain.value = selectElement.value.split("-")[4]
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templating.template_with_sidebar', ['isActiveTrx' => 'active'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u726706882/domains/sistem.oklusif.com/public_html/resources/views/transaction/transaction_preview.blade.php ENDPATH**/ ?>