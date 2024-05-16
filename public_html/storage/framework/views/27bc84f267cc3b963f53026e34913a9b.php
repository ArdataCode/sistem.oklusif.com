<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Dental Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="css/main.css" />

    <style>
        .background {
            background-image: url('clinic-banner.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover
        }

        .image-sides {
            width: 450px;
        }
    </style>
</head>

<body class="background show-spinner no-footer">
    
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-6">
                            <div class="card auth-card w-100">
                                
                                
                                
                                <div class="form-side w-100">
                                    <div class="text-center mb-3">
                                        <center>
                                            <img src="https://oklusif.com/wp-content/uploads/2022/10/Logo-PNG-New-Oklusif.png" alt="Oklusif-logo" class="mb-3" width="300">
                                        </center>
                                        <h2>Hello! Selamat Datang</h2>
                                        <h6 class="text-muted">Silahkan Login dengan Akun Anda</h6>
                                    </div>
                                    <h6 class="mb-4">Login</h6>
                                    <form method="POST" action="<?php echo e(route('auth')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <label class="form-group has-float-label mb-4">
                                            <input class="form-control" name="email" type="email" required />
                                            <span>E-mail</span>
                                        </label>

                                        <label class="form-group has-float-label mb-4">
                                            <input class="form-control" type="password" required placeholder="" name="password" />
                                            <span>Password</span>
                                        </label>

                                        <?php if(session()->has('error')): ?>
                                        <div class="alert alert-danger p-1" role="alert">
                                            <?php echo e(session()->get('error')); ?>

                                        </div>
                                        <?php endif; ?>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <!-- <a href="#">Forget password?</a> -->
                                            <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/vendor/jquery-3.3.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/dore.script.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html><?php /**PATH /home/u726706882/domains/sistem.oklusif.com/public_html/resources/views/login.blade.php ENDPATH**/ ?>