<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= config('App')->appName ?? 'BKK & Tracer Study' ?> - Login</title>
    <link rel="icon" href="<?= base_url('assets/media/logos/tp4.png') ?>" type="image/png">
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <style>
        body.login-page {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 55%, #084298 100%);
            min-height: 100vh;
        }

        .login-page-bg {
            background-color: transparent;
            min-height: 100vh;
        }
    </style>
</head>

<body id="kt_body" class="bg-body login-page">
    <?= $this->renderSection('content') ?>
    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom/authentication/sign-in/general.js') ?>"></script>
    <!-- <script src="<?= base_url('assets/js/custom/authentication/sign-up/general.js') ?>"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?= session()->getFlashdata('success') ?>',
                    timer: 3000,
                    showConfirmButton: false
                });
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '<?= session()->getFlashdata('error') ?>',
                    timer: 3000,
                    showConfirmButton: false
                });
            <?php endif; ?>
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>