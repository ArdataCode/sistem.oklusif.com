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
<h1>Preview Pasien <?php echo e($data_patient->nama_pasien); ?></h1>
<div class="separator mb-5"></div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <button id="downloadPasien" class="btn btn-primary">
                <i class="iconsminds-simple-icon-printer"></i> Download Pasien</button>
        </div>
        <p class="text-lg" style="font-size: 18px;">Nama Pasien: <?php echo e($data_patient->nama_pasien); ?></p>
        <p class="text-lg" style="font-size: 18px;">No Rekam Medis: <?php echo e($data_patient->nomor_rekam_medis); ?></p>
        <p class="text-lg" style="font-size: 18px;">Alamat: <?php echo e($data_patient->alamat); ?></p>
        <p class="text-lg" style="font-size: 18px;">No. Telp: <?php echo e($data_patient->telepon); ?></p>
        <p class="text-lg" style="font-size: 18px;">Tempat Lahir: <?php echo e($data_patient->tempat_lahir); ?></p>
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
                    <?php if($data_patient->transactions != null): ?>
                    <?php $__currentLoopData = $data_patient->transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th rowspan="<?php echo e(count($transaction->transaction_tindak) + 1); ?>"><?php echo e($transaction->tgl_transaksi); ?></th>
                    </tr>
                    <?php $__currentLoopData = $transaction->transaction_tindak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tindakan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($tindakan->tindakan->nama_tindakan ?? ''); ?></td>
                        <td><?php echo e($transaction->dokter->nama); ?></td>
                        <td><?php echo e($transaction->keterangan); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4">Belum Ada Transaksi</td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const downloadPasien = document.getElementById('downloadPasien')

    downloadPasien.addEventListener('click', function() {
        fetch(`
                /pasien-download?id=<?php echo e($data_patient->id); ?>

                `, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
            .then(response => response.blob())
            .then(blob => {
                // Create a temporary URL for the blob
                const url = URL.createObjectURL(blob);

                // Create a link element and simulate a click to trigger the download
                const a = document.createElement('a');
                a.href = url;
                a.download = `Pasien_<?php echo e($data_patient->nama_pasien); ?>.pdf`;
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();

                // Clean up the temporary URL and remove the link element
                URL.revokeObjectURL(url);
                document.body.removeChild(a);
            })
            .catch(error => console.error(error));
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templating.template_with_sidebar', ['isActivePasien' => 'active'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u726706882/domains/sistem.oklusif.com/public_html/resources/views/pasien/pasien_preview.blade.php ENDPATH**/ ?>