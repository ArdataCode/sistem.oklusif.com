<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .tabelTindakan thead tr th {
        border-bottom: 2px solid black;
    }

    .wrapperMain {
        width: 100%;
    }

    .fs10px {
        font-size: 9px;
    }

    .fs12px {
        font-size: 12px;
    }

    .text-center {
        text-align: center;
    }

    .textRight {
        text-align: right;
    }

    .dFlexBetween {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .wrapperMain {
        border: 2.5px solid black;
        border-style: dotted;
        padding: 3px;
    }
</style>

<div class="wrapperMain">
    <table style="width: 100%; padding: 0px;">
        <tr>
            <td style="text-align: left;">
                <img src="https://oklusif.com/wp-content/uploads/2022/10/Logo-PNG-New-Oklusif.png" alt="LOGO" width="100">
            </td>
            <td style="text-align: right;">
                <p class="fs10px">Bandung <?php echo e($data['tanggal']); ?></p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 0px;">
        <tr>
            <td style="text-align: left;">
                <p class="fs10px">
                    <span style="font-weight: bold;">RINCIAN RAWAT JALAN PASIEN</span>
                    <br>
                    PRAKTEK DOKTER GIGI SPESIALISTIK
                    <br>
                    Jl. Tanjung Sari No.32, Antapani. Bandung 08112276161
                </p>
            </td>
            <td style="text-align: right;">
                <p class="fs10px" style="">
                    No. <?php echo e($data['notrx']); ?>

                    <br>
                    Nama Pasien: <?php echo e($data['nama_pasien']); ?>

                    <br>
                    No telp Pasien: <?php echo e($data['notelp']); ?>

                </p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 0px;" cellspacing="5" class="tabelTindakan">
        <thead>
            <tr>
                <th class="fs12px">No</th>
                <th class="fs12px">Nama Tindakan</th>
                <th class="fs12px">Qty</th>
                <th class="fs12px">Harga</th>
                <th class="fs12px">Diskon%</th>
                <th class="fs12px">Jumlah</th>
            </tr>
        </thead>
        <tbody id="rowTindakan">
            <?php $sortedTindakans = collect($data['tindakans'])
                ->sortBy('nama_tindakan')
                ->toArray(); ?>
            <?php
            $number = 1;
            foreach ($sortedTindakans as $key => $value) : ?>
            <tr>
                <td class="fs12px text-center"><?php echo $number++; ?></td>
                <td class="fs12px text-center"><?php echo $value['nama_tindakan']; ?></td>
                <td class="fs12px text-center"><?php echo $value['quantity']; ?></td>
                <td class="fs12px text-center"><?php echo number_format(intval($value['biaya']), 0, ',', '.'); ?></td>
                <td class="fs12px text-center"><?php echo $value['discount']; ?></td>
                <td class="fs12px text-center"><?php echo number_format($value['subtotal'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <strong>
        <p style="font-size: 12px; text-align: right;">Total: Rp. <?php echo e(number_format(intval($data['totally']), 0, ',', '.')); ?></p>
    </strong>

    <p style="text-align: left;" class="fs10px">
        Keterangan Dokter:
        <br>
        <span style="
        text-align: left; 
        word-wrap: break-word;
        white-space: -moz-pre-wrap;
        white-space: pre-wrap;
        "><?php echo e($data['keterangan']); ?></span>
    </p>

    <table style="width: 100%; padding: 0px; padd">
        <tr>
            <td style="text-align: left;">
                <p class="fs10px">
                    <span>
                        Perhatian
                    </span>
                    <br>
                    Kuitansi ini merupakan bukti pembayaran yang sah
                </p>
            </td>
            <td style="text-align: right;">
                <p class="fs10px">
                    <span style="padding-right: 12px;">Hormat Kami,</span>
                    <br><br><br><br>
                    (.........................)
                </p>
            </td>
        </tr>
    </table>


</div>
<?php /**PATH /home/1126019.cloudwaysapps.com/ajuyqjhjns/public_html/resources/views/transaction/nota.blade.php ENDPATH**/ ?>