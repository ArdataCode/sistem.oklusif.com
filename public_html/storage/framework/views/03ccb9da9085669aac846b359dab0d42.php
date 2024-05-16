<style>
    /* table, */
    table th,
    td {
        border: 1px solid black;
        text-align: center;
        padding: 10px;
    }
</style>

<h1>Pasien <?php echo e($data_patient->nama_pasien); ?></h1>
<div class="separator mb-5"></div>

<div class="card">
    <div class="card-body">
        <p class="text-lg" style="font-size: 18px;">Nama Pasien: <?php echo e($data_patient->nama_pasien); ?></p>
        <p class="text-lg" style="font-size: 18px;">No Rekam Medis: <?php echo e($data_patient->nomor_rekam_medis); ?></p>
        <p class="text-lg" style="font-size: 18px;">Alamat: <?php echo e($data_patient->alamat); ?></p>
        <p class="text-lg" style="font-size: 18px;">No. Telp: <?php echo e($data_patient->telepon); ?></p>
        <p class="text-lg" style="font-size: 18px;">Tanggal Lahir: <?php echo e(explode(' ', $data_patient->tgl_lahir)[0]); ?></p>
        <p class="text-lg" style="font-size: 18px;">Jumlah Transaksi: <?php echo e(count($data_patient->transactions) ?? 0); ?></p>

        <div class="mt-2">
            <p class="text-lg" style="font-size: 18px;" class="text-muted">Rekam Medis</p>

            <table border="1" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tindakan</th>
                        <th>Dokter</th>
                        <th>Keterangan Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data_patient->transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th rowspan="<?php echo e(count($transaction->transaction_tindak) + 1); ?>"><?php echo e($transaction->tgl_transaksi); ?></th>
                    </tr>
                    <?php $__currentLoopData = $transaction->transaction_tindak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tindakan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($tindakan->tindakan->nama_tindakan); ?></td>
                        <td><?php echo e($transaction->dokter->nama); ?></td>
                        <td><?php echo e($transaction->keterangan); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /home/1126019.cloudwaysapps.com/ajuyqjhjns/public_html/resources/views/pasien/pasien_pdf.blade.php ENDPATH**/ ?>