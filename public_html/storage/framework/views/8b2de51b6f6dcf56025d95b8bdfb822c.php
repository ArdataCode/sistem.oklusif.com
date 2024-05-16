<style>
    .inputRange:focus {}

    .inputRange {
        font-size: 15px;
        padding: 5px;
        border: none;
    }
</style>
<?php $__env->startSection('content'); ?>
    <h1>Transactions</h1>
    <div class="separator mb-3"></div>
    <?php if(session()->has('success')): ?>
        <div class="alert alert-info p-2 my-2" role="alert">
            <?php echo e(session()->get('success')); ?>

        </div>
    <?php endif; ?>

    <div class="mb-3">
        Range Tanggal Transaksi: <input type="text" class="inputRange" id="minDate" placeholder="Dari Tanggal"> - <input type="text" class="inputRange" id="maxDate" placeholder="Sampai Tanggal">
    </div>
    

    <table id="transactions_table" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pasien</th>
                <th>Dokter</th>
                <th>List Tindakan</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($transaction->nomor_transaksi); ?></td>
                    <td><?php echo e(date('d-F-Y', strtotime($transaction->tgl_transaksi))); ?></td>
                    <td><?php echo e($transaction->pasien->nama_pasien ?? ''); ?></td>
                    <td><?php echo e($transaction->dokter->nama ?? ''); ?></td>
                    <td>
                        <?php if($transaction->transaction_tindak !== null): ?>
                            <?php $__currentLoopData = $transaction->transaction_tindak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tindakan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span style="font-size: 12px;"><?php echo e($tindakan->tindakan->nama_tindakan ?? '' . ', '); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(number_format($transaction->transaction_tindak->sum('subtotal'), 0, ',', '.')); ?></td>
                    <td>
                        <a href="/transaction_preview?id=<?php echo e($transaction->id); ?>" class="btn btn-sm btn-info">Preview</a>
                        <a href="#" id="notaBtn<?php echo e($transaction->id); ?>" class="btn btn-sm btn-primary" data-nomor_transaksi="<?php echo e($transaction->nomor_transaksi); ?>"
                            data-tanggal_transaksi="<?php echo e($transaction->tgl_transaksi); ?>" data-nama_pasien="<?php echo e($transaction->pasien->nama_pasien ?? ''); ?>"
                            data-telepon_pasien="<?php echo e($transaction->pasien ? $transaction->pasien->telepon : ''); ?>" data-keterangan="<?php echo e($transaction->keterangan); ?>" data-data_tindakans="<?php echo e($transaction->transaction_tindak); ?>"
                            onclick="downloadNota('<?php echo e($transaction->id); ?>')">Nota</a>
                        <a href="/transaction/delete/<?php echo e($transaction->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>

                        <script>
                            function downloadNota(id) {
                                const notrx = $('#notaBtn' + id).data('nomor_transaksi');
                                const tgl_transaksi = $('#notaBtn' + id).data('tanggal_transaksi');
                                const nama_pasien = $('#notaBtn' + id).data('nama_pasien');
                                const telepon_pasien = $('#notaBtn' + id).data('telepon_pasien');
                                const keterangan = $('#notaBtn' + id).data('keterangan');
                                const data_tindakans = $('#notaBtn' + id).data('data_tindakans');

                                const tindakans = data_tindakans;
                                const totally = tindakans.reduce(function(accumulator, currentValue) {
                                    return accumulator + currentValue.subtotal;
                                }, 0).toString();

                                tindakans.map(tdk => tdk["nama_tindakan"] = tdk["tindakan"]["nama_tindakan"]);

                                fetch(`
                                    /download-nota?tanggal=${tgl_transaksi}
                                    &notrx=${notrx}
                                    &nama_pasien=${nama_pasien}
                                    &keterangan=${keterangan}
                                    &notelp=${telepon_pasien}
                                    &totally=${totally}
        `, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        body: JSON.stringify({
                                            data_tindakan: tindakans
                                        })
                                    })
                                    .then(response => response.blob())
                                    .then(blob => {
                                        // Create a temporary URL for the blob
                                        const url = URL.createObjectURL(blob);

                                        // Create a link element and simulate a click to trigger the download
                                        const a = document.createElement('a');
                                        a.href = url;
                                        a.download = `${notrx}.pdf`;
                                        a.style.display = 'none';
                                        document.body.appendChild(a);
                                        a.click();

                                        // Clean up the temporary URL and remove the link element
                                        URL.revokeObjectURL(url);
                                        document.body.removeChild(a);
                                    })
                                    .catch(error => console.error(error));
                            }
                        </script>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pasien</th>
                <th>Dokter</th>
                <th>List Tindakan</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-end mt-3">
        <p>Total <?php echo e($countData); ?> Transaksi</p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templating.template_with_sidebar', ['isActiveTrx' => 'active'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u726706882/domains/sistem.oklusif.com/public_html/resources/views/transaction/transaction.blade.php ENDPATH**/ ?>