<style>
    table {
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        text-align: center;
        padding: 10px;
    }
</style>
<?php $__env->startSection('content'); ?>
<h1>Kinerja Dokter</h1>
<div class="separator mb-3"></div>
<div class="card">
    <div class="card-body">
        <form action="/lapor_kinerja" method="get">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="Pilih Dokter">Pilih Dokter</label>
                        <select required name="dokter" id="dokter" class="form-control">
                            <option value="" selected>Pilih Dokter</option>
                            <?php $__currentLoopData = $data_dokters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="Pilih Dokter">Rentang Tanggal</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input required type="date" class="form-control" placeholder="Tanggal Awal" name="startDate">
                            </div>

                            <div class="col-md-6">
                                <input required type="date" class="form-control" placeholder="Tanggal Akhir" name="endDate">
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

<?php if($data_kinerja != null): ?>
<div class="card mt-3">
    <div class="card-body">
        <div class="card-title d-flex justify-content-between" id="testyoyy">
            <span>
                Laporan Kinerja Dokter <?php echo e($dataInfo['nama_dokter']); ?>, di rentang tanggal <?php echo e($dataInfo['startDate']); ?> hingga <?php echo e($dataInfo['endDate']); ?>

            </span>
            <a href="/kinerja/download?dokter_id=<?php echo e($dataInfo['dokter_id']); ?>&startDate=<?php echo e($dataInfo['startDate2']); ?>&endDate=<?php echo e($dataInfo['endDate2']); ?>&total=<?php echo e($total); ?>" class="btn btn-success">Download
                Excel</a>
        </div>
        <table border="1" cellspacing="0" id="table_kinerja">
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nomor Transaksi</th>
                    <th scope="col">Nama Pasien</th>
                    <th scope="col">Jenis Tindakan</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Jasa Medis</th>
                    <th scope="col">Biaya Lain</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data_kinerja; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td rowspan="<?php echo e(count($transaction->transaction_tindak) + 1); ?>"><?php echo e($transaction->created_at->format('d-F-Y')); ?></td>
                    <td rowspan="<?php echo e(count($transaction->transaction_tindak) + 1); ?>"><?php echo e($transaction->nomor_transaksi); ?></td>
                    <td rowspan="<?php echo e(count($transaction->transaction_tindak) + 1); ?>"><?php echo e($transaction->pasien ? $transaction->pasien->nama_pasien : ""); ?></td>
                </tr>
                <?php $__currentLoopData = $transaction->transaction_tindak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tindakan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($tindakan->tindakan->nama_tindakan ?? ''); ?></td>
                    <td><?php echo e($tindakan->quantity); ?></td>
                    <td>Rp. <?php echo e(number_format($tindakan->biaya, 0, ',', '.')); ?></td>
                    <td><?php echo e($tindakan->discount); ?></td>
                    <td>Rp. <?php echo e(number_format($tindakan->subtotal, 0, ',', '.')); ?></td>
                    <td>Rp. <?php echo e(number_format($tindakan->quantity * $tindakan->tindakan->jasa_medis ?? "", 0, ',', '.')); ?></td>
                    <td>Rp. <?php echo e(number_format($tindakan->biayalain, 0, ',', '.')); ?></td>
                    <td><?php echo e($tindakan->keteranganlain); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td colspan="5">Total</td>
                    <td colspan="4"><strong>Rp. <?php echo e(number_format($total, 0, ',', '.')); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<span></span>
<?php endif; ?>

<script>
    console.log("TEST");
</script>
<?php $__env->stopSection(); ?>
<script>
    console.log("TEST");
</script>
<?php echo $__env->make('templating.template_with_sidebar', ['isActiveKinerja' => 'active'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u726706882/domains/sistem.oklusif.com/public_html/resources/views/dokter/kinerja.blade.php ENDPATH**/ ?>