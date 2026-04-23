<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= config('app.name') ?? 'BKK & Tracer Study' ?></title>
    <link rel="icon" href="<?= base_url('assets/media/logos/tp4.png') ?>" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css') ?>" rel="stylesheet" type="text/css" />

</head>

<body id="kt_body" class=" header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed">
    <?= $this->include('admin/layout/partials/sidebar') ?>
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <?= $this->include('admin/layout/partials/header') ?>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <?= $this->renderSection('content') ?>
        </div>
        <?= $this->include('admin/layout/partials/footer') ?>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom/widgets.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom/apps/chat/chat.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom/modals/new-target.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom/modals/upgrade-plan.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom/modals/modal-form-handler.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Global SweetAlert handlers
        $(document).ready(function() {
            // Auto-show flash messages
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

            // Global delete confirmation
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const button = $(this);
                const url = button.attr('href') || button.data('url');
                const title = button.data('title') || 'Apakah Anda yakin?';
                const text = button.data('text') || 'Tindakan ini tidak dapat dibatalkan!';

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (url) {
                            window.location.href = url;
                        } else {
                            // For forms or other actions
                            const form = button.closest('form');
                            if (form.length) {
                                form.submit();
                            }
                        }
                    }
                });
            });

            // Global form confirmation
            $(document).on('submit', '.confirm-submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const title = form.data('confirm-title') || 'Konfirmasi';
                const text = form.data('confirm-text') || 'Apakah Anda yakin ingin melanjutkan?';

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form[0].submit();
                    }
                });
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>