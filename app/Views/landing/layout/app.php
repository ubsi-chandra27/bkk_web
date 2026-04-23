<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMK Teratai Putih Global 4 - <?= esc($title ?? 'BKK & Tracer Study') ?></title>
    <link rel="icon" href="<?= base_url('assets/media/logos/tp4.png') ?>" type="image/png">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <!-- Metronic & Plugins -->
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css') ?>" rel="stylesheet" />

    <!-- Custom landing styles -->
    <style>
        .hover-elevate-up {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-elevate-up:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.10) !important;
        }

        .card-lowongan .btn-apply {
            transition: background 0.2s ease;
        }



        /* Badge status lowongan */
        .badge-deadline-warning {
            background: #fff4de;
            color: #ffa800;
        }

        .badge-deadline-danger {
            background: #ffe2e5;
            color: #f1416c;
        }

        .badge-deadline-ok {
            background: #e8fff3;
            color: #50cd89;
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body id="kt_body"
    data-bs-spy="scroll"
    data-bs-target="#kt_landing_menu"
    data-bs-offset="200"
    class="bg-white position-relative d-flex flex-column min-vh-100">

    <div class="d-flex flex-column flex-root flex-grow-1">

        <!-- Header -->
        <?= $this->include('landing/layout/partials/header') ?>

        <!-- Mobile Sidebar -->
        <?= $this->include('landing/layout/partials/sidebar') ?>

        <!-- Main Content -->
        <main class="flex-grow-1">
            <?= $this->renderSection('content') ?>
        </main>

    </div>

    <!-- Footer -->
    <?= $this->include('landing/layout/partials/footer') ?>

    <!-- Scroll to top -->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
            </svg>
        </span>
    </div>

    <!-- JS Bundle -->
    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/fslightbox/fslightbox.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/typedjs/typedjs.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom/landing.js') ?>"></script>

    <script>
        // Safe KTMenu init
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof KTMenu !== 'undefined') {
                try {
                    KTMenu.createInstances('[data-kt-menu="true"]');
                } catch (e) {}
            }
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>