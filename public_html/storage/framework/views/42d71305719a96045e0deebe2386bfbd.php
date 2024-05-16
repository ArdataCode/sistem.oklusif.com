<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Oklusif System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="css/vendor/component-custom-switch.min.css" />
    <link rel="stylesheet" href="css/vendor/perfect-scrollbar.css" />

    <link rel="stylesheet" href="css/main.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">
</head>

<body id="app-container" class="menu-default show-spinner">
    <nav class="navbar fixed-top">
        <div class="d-flex align-items-center navbar-left">
            <a href="#" class="menu-button d-none d-md-block">
                <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                    <rect x="0.48" y="0.5" width="7" height="1" />
                    <rect x="0.48" y="7.5" width="7" height="1" />
                    <rect x="0.48" y="15.5" width="7" height="1" />
                </svg>
                <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                    <rect x="1.56" y="0.5" width="16" height="1" />
                    <rect x="1.56" y="7.5" width="16" height="1" />
                    <rect x="1.56" y="15.5" width="16" height="1" />
                </svg>
            </a>

            <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                    <rect x="0.5" y="0.5" width="25" height="1" />
                    <rect x="0.5" y="7.5" width="25" height="1" />
                    <rect x="0.5" y="15.5" width="25" height="1" />
                </svg>
            </a>
        </div>


        <a class="navbar-logo" href="/">
            <h1>Oklusif System</h1>
        </a>

        <div class="navbar-right">
            <div class="header-icons d-inline-block align-middle">
                <div class="d-none d-md-inline-block align-text-bottom mr-3">
                    <div class="custom-switch custom-switch-primary-inverse custom-switch-small pl-1" data-toggle="tooltip" data-placement="left" title="Dark Mode">
                        <input class="custom-switch-input" id="switchDark" type="checkbox" checked>
                        <label class="custom-switch-btn" for="switchDark"></label>
                    </div>
                </div>

            </div>

            <div class="user d-inline-block">
                <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="name"><?php echo e(auth()->user()->nama ?? 'Pengguna'); ?></span>
                    <span>
                        <img alt="Profile Picture" src="/uploadedimages/<?php echo e(auth()->user()->image); ?>" />
                    </span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-3">
                    
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalUpdateFoto">Update Foto</a>
                    <a class="dropdown-item" href="/logout">Sign out</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="modalUpdateFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Foto Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/update-foto" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input class="form-control" name="image" accept="image/png, image/jpeg, image/jpg" type="file" required id="image" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="menu">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    <li id="menu_sidebar" class="test <?php echo e($isActiveDashboard ?? ''); ?>">
                        <a href="/">
                            <i class="iconsminds-notepad"></i>
                            <span>Nota</span>
                        </a>
                    </li>
                    <?php if(auth()->user()->role != 'Dokter' && auth()->user()->role != 'Admin'): ?>
                    <li id="menu_sidebar" class="test <?php echo e($isActiveInfografis ?? ''); ?>">
                        <a href="/infografis">
                            <i class="iconsminds-line-chart-1"></i> Infografis
                        </a>
                    </li>
                    <?php endif; ?>
                    <li id="menu_sidebar" class="test <?php echo e($isActiveTrx ?? ''); ?>">
                        <a href="/transaction">
                            <i class="iconsminds-optimization"></i> Transaksi
                        </a>
                    </li>
                    <li id="menu_sidebar" class="test <?php echo e($isActivePasien ?? ''); ?>">
                        <a href="/pasien">
                            <i class="iconsminds-male-female"></i> Data Pasien
                        </a>
                    </li>
                    <li id="menu_sidebar" class="test <?php echo e($isActiveTindakan ?? ''); ?>">
                        <a href="/tindakan">
                            <i class="iconsminds-pantone"></i> Data Tindakan
                        </a>
                    </li>

                    <?php if(auth()->user()->role != 'Dokter'): ?>
                    <li id="menu_sidebar" class="test <?php echo e($isActiveDokter ?? ''); ?>">
                        <a href="/dokter">
                            <i class="iconsminds-user"></i> Data Dokter
                        </a>
                    </li>

                    <?php if(auth()->user()->role != 'Admin'): ?>
                    <li id="menu_sidebar" class="test <?php echo e($isActiveKinerja ?? ''); ?>">
                        <a href="/kinerja">
                            <i class="iconsminds-stethoscope"></i> Kinerja Dokter
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(auth()->user()->role != 'Dokter' && auth()->user()->role != 'Admin'): ?>
                    <li id="menu_sidebar" class="test <?php echo e($isActiveUser ?? ''); ?>">
                        <a href="/user">
                            <i class="iconsminds-business-mens"></i> User
                        </a>
                    </li>
                    <?php endif; ?>

                    
                </ul>
            </div>
        </div>

        
    </div>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
    </main>

    <footer class="page-footer">
        <div class="footer-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <p class="mb-0 text-muted">Oklusif System 2023</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="js/vendor/jquery-3.3.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/vendor/perfect-scrollbar.min.js"></script>
    <script src="js/vendor/Chart.bundle.min.js"></script>
    <script src="js/vendor/chartjs-plugin-datalabels.js"></script>
    <script src="js/vendor/mousetrap.min.js"></script>
    <script src="js/dore.script.js"></script>
    <script src="js/scripts.js"></script>
    
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.4.1/js/dataTables.dateTime.min.js"></script>

    <script>
        $(document).ready(function() {
            var doc = new jsPDF('p', 'mm', [148, 210]);
            var specialElementHandlers = {
                '#editor': function(element, renderer) {
                    return true;
                }
            };

            $('#printPdf').click(function() {
                doc.fromHTML($('#struk').html());
                doc.save('sample-struk.pdf');
            });

            var minEl = $('#minFee');
            var maxEl = $('#maxFee');

            var table = $('#datatable').DataTable({
                dom: 'Bfrtip',
                scrollX: true,
                buttons: [{
                    extend: 'excel',
                    text: "Download Excel",
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                }]
            });

            // if (window.location.pathname = "/tindakan") {
            // Custom range filtering function
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var min = parseInt(minEl.val(), 10);
                var max = parseInt(maxEl.val(), 10);
                var total_harga = 200000;
                // var total_harga = parseFloat(data[5].split(" ")[1].replace('.', '')) || 0; // use data for the total_harga column

                if (
                    (isNaN(min) && isNaN(max)) ||
                    (isNaN(min) && total_harga <= max) ||
                    (min <= total_harga && isNaN(max)) ||
                    (min <= total_harga && total_harga <= max)
                ) {
                    return true;
                }

                return false;
            });

            minEl.on('input', function() {
                table.draw();
            });
            maxEl.on('input', function() {
                table.draw();
            });
            // }

            $('#menu_sidebar').on('click', function() {
                // $('#menu_sidebar').removeClass('active')
                $('#menu_sidebar').addClass('active')
            })


            var minDate, maxDate, minModif, maxModif;

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = minDate.val();
                    var max = maxDate.val();
                    var date = new Date(data[2]);

                    minModif = new Date(new Date(min).setDate(new Date(min).getDate() - 1));
                    // maxModif = new Date(new Date(max).setDate(new Date(max).getDate() + 1));

                    if (
                        (minModif === null && max === null || min === null && max === null) ||
                        (minModif === null && date <= max || min === null && date <= max) ||
                        (minModif <= date && max === null || min <= date && max === null) ||
                        (minModif <= date && date <= max || min <= date && date <= max)
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            minDate = new DateTime($('#minDate'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#maxDate'), {
                format: 'MMMM Do YYYY'
            });

            // DataTables initialisation
            var tableTransaction = $('#transactions_table').DataTable({
                dom: 'Bfrtip',
                scrollX: true,
                buttons: [{
                    extend: 'excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                }]
            });

            // DataTables initialisation
            var tablePatient = $('#table_patient').DataTable({
                dom: 'Bfrtip',
                scrollX: true,
                buttons: [{
                    extend: 'excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                }]
            });

            // Refilter the table
            $('#minDate, #maxDate').on('change', function() {
                tableTransaction.draw();
                table.draw();
            });

        });

        // const downloadButton = document.getElementById('downloadButton');
        // downloadButton.addEventListener('click', () => {
        //     const content = document.getElementById('content');
        //     html2pdf()
        //         .set({
        //             margin: 10,
        //             filename: 'file.pdf',
        //             image: {
        //                 type: 'jpeg',
        //                 quality: 0.98
        //             },
        //             html2canvas: {
        //                 dpi: 192,
        //                 letterRendering: true
        //             },
        //             jsPDF: {
        //                 unit: 'mm',
        //                 format: 'a4',
        //                 orientation: 'portrait'
        //             },
        //         })
        //         .from(content)
        //         .save();
        // });
    </script>
</body>

</html><?php /**PATH /home/u726706882/domains/sistem.oklusif.com/public_html/resources/views/templating/template_with_sidebar.blade.php ENDPATH**/ ?>