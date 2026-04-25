<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= config('app.name') ?? 'BKK & Tracer Study' ?></title>
    <link rel="icon" href="<?= base_url('assets/media/logos/tp4.png') ?>" type="image/png">
    <script>
        (function() {
            var savedTheme = localStorage.getItem('admin-theme') || 'light';
            document.documentElement.setAttribute('data-admin-theme', savedTheme);
        })();
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <style>
        [data-admin-theme="dark"] body,
        body[data-admin-theme="dark"] {
            background-color: #111827;
            color: #e5e7eb;
        }

        [data-admin-theme="dark"] #kt_body,
        body[data-admin-theme="dark"] #kt_body,
        body[data-admin-theme="dark"] {
            background-color: #111827;
        }

        body[data-admin-theme="dark"] .wrapper,
        body[data-admin-theme="dark"] .content,
        body[data-admin-theme="dark"] .container-xxl,
        body[data-admin-theme="dark"] .container-fluid {
            background-color: transparent;
        }

        body[data-admin-theme="dark"] .header {
            background-color: #0f172a;
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        body[data-admin-theme="dark"] .footer,
        body[data-admin-theme="dark"] #kt_footer {
            background-color: #0f172a;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        body[data-admin-theme="dark"] .aside,
        body[data-admin-theme="dark"] .aside-light {
            background-color: #0b1220;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        body[data-admin-theme="dark"] .aside .menu-link,
        body[data-admin-theme="dark"] .aside .menu-title,
        body[data-admin-theme="dark"] .aside .menu-icon,
        body[data-admin-theme="dark"] .aside .menu-section,
        body[data-admin-theme="dark"] .footer .menu-link,
        body[data-admin-theme="dark"] .footer a,
        body[data-admin-theme="dark"] .header,
        body[data-admin-theme="dark"] .header .btn,
        body[data-admin-theme="dark"] .header .text-dark,
        body[data-admin-theme="dark"] .footer .text-dark,
        body[data-admin-theme="dark"] .text-dark,
        body[data-admin-theme="dark"] .card-title,
        body[data-admin-theme="dark"] .card-label,
        body[data-admin-theme="dark"] .menu-link,
        body[data-admin-theme="dark"] .menu-title,
        body[data-admin-theme="dark"] .page-title,
        body[data-admin-theme="dark"] label,
        body[data-admin-theme="dark"] .form-label {
            color: #e5e7eb !important;
        }

        body[data-admin-theme="dark"] .text-muted,
        body[data-admin-theme="dark"] .text-gray-400,
        body[data-admin-theme="dark"] .text-gray-500,
        body[data-admin-theme="dark"] .text-gray-600,
        body[data-admin-theme="dark"] .footer .text-muted,
        body[data-admin-theme="dark"] .footer .menu-gray-600,
        body[data-admin-theme="dark"] .footer .menu-gray-600 .menu-link {
            color: #94a3b8 !important;
        }

        body[data-admin-theme="dark"] .footer .menu-link:hover,
        body[data-admin-theme="dark"] .footer a:hover {
            color: #60a5fa !important;
        }

        body[data-admin-theme="dark"] .svg-icon svg [fill]:not([fill="none"]) {
            fill: #e5e7eb !important;
        }

        body[data-admin-theme="dark"] .btn.btn-icon,
        body[data-admin-theme="dark"] .btn.btn-light,
        body[data-admin-theme="dark"] .btn.btn-bg-light,
        body[data-admin-theme="dark"] .btn-active-light-primary,
        body[data-admin-theme="dark"] .bg-light,
        body[data-admin-theme="dark"] .bg-light-dark,
        body[data-admin-theme="dark"] .bg-light-primary,
        body[data-admin-theme="dark"] .bg-light-info,
        body[data-admin-theme="dark"] .bg-light-success,
        body[data-admin-theme="dark"] .bg-light-warning,
        body[data-admin-theme="dark"] .bg-light-danger {
            background-color: #1e293b !important;
            color: #e5e7eb !important;
        }

        body[data-admin-theme="dark"] .btn.btn-light:hover,
        body[data-admin-theme="dark"] .btn.btn-bg-light:hover,
        body[data-admin-theme="dark"] .btn-active-light-primary:hover {
            background-color: #334155 !important;
            color: #ffffff !important;
        }

        body[data-admin-theme="dark"] .card,
        body[data-admin-theme="dark"] .modal-content,
        body[data-admin-theme="dark"] .dropdown-menu,
        body[data-admin-theme="dark"] .menu-sub-dropdown,
        body[data-admin-theme="dark"] .dataTables_wrapper .dataTables_length select,
        body[data-admin-theme="dark"] .dataTables_wrapper .dataTables_filter input {
            background-color: #1f2937 !important;
            color: #e5e7eb !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: none !important;
        }

        body[data-admin-theme="dark"] .card-header,
        body[data-admin-theme="dark"] .card-footer,
        body[data-admin-theme="dark"] .modal-header,
        body[data-admin-theme="dark"] .modal-footer,
        body[data-admin-theme="dark"] .border,
        body[data-admin-theme="dark"] .border-bottom,
        body[data-admin-theme="dark"] .border-top,
        body[data-admin-theme="dark"] .border-dashed,
        body[data-admin-theme="dark"] .separator {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        body[data-admin-theme="dark"] .form-control,
        body[data-admin-theme="dark"] .form-select,
        body[data-admin-theme="dark"] .form-control.form-control-solid,
        body[data-admin-theme="dark"] textarea.form-control,
        body[data-admin-theme="dark"] select.form-control {
            background-color: #0f172a !important;
            color: #e5e7eb !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        body[data-admin-theme="dark"] .form-control::placeholder {
            color: #94a3b8 !important;
        }

        body[data-admin-theme="dark"] .table,
        body[data-admin-theme="dark"] .table td,
        body[data-admin-theme="dark"] .table th,
        body[data-admin-theme="dark"] .table tr,
        body[data-admin-theme="dark"] .dataTables_info,
        body[data-admin-theme="dark"] .dataTables_paginate,
        body[data-admin-theme="dark"] .page-link {
            color: #e5e7eb !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        body[data-admin-theme="dark"] .table > :not(caption) > * > * {
            background-color: transparent !important;
            box-shadow: inset 0 0 0 9999px transparent !important;
        }

        body[data-admin-theme="dark"] table.dataTable tbody tr,
        body[data-admin-theme="dark"] .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03) !important;
        }

        body[data-admin-theme="dark"] .table thead tr,
        body[data-admin-theme="dark"] .table thead th,
        body[data-admin-theme="dark"] .bg-light.text-muted,
        body[data-admin-theme="dark"] tr.bg-light {
            background-color: #182131 !important;
            color: #cbd5e1 !important;
        }

        body[data-admin-theme="dark"] .page-link,
        body[data-admin-theme="dark"] .paginate_button a {
            background-color: #1f2937 !important;
        }

        body[data-admin-theme="dark"] .page-item.active .page-link {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #fff !important;
        }

        body[data-admin-theme="dark"] .modal-header .btn-close {
            filter: invert(1);
        }

        body[data-admin-theme="dark"] .swal2-popup {
            background: #1f2937;
            color: #e5e7eb;
        }
    </style>

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
        (function() {
            window.applyAdminTheme = function(theme) {
                const selectedTheme = theme === 'dark' ? 'dark' : 'light';

                document.documentElement.setAttribute('data-admin-theme', selectedTheme);
                document.body.setAttribute('data-admin-theme', selectedTheme);
                localStorage.setItem('admin-theme', selectedTheme);

                document.querySelectorAll('[data-theme-toggle-label]').forEach(function(label) {
                    label.textContent = selectedTheme === 'dark' ? 'Dark Mode' : 'Light Mode';
                });

                document.querySelectorAll('[data-theme-toggle-icon]').forEach(function(icon) {
                    icon.className = selectedTheme === 'dark' ? 'fas fa-sun fs-2' : 'fas fa-moon fs-2';
                });

                document.querySelectorAll('[data-theme-toggle-button]').forEach(function(button) {
                    button.setAttribute('aria-pressed', selectedTheme === 'dark' ? 'true' : 'false');
                    button.setAttribute('title', selectedTheme === 'dark' ? 'Ganti ke light mode' : 'Ganti ke dark mode');
                });
            };

            document.addEventListener('DOMContentLoaded', function() {
                window.applyAdminTheme(localStorage.getItem('admin-theme') || 'light');

                document.querySelectorAll('[data-theme-toggle-button]').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const nextTheme = (localStorage.getItem('admin-theme') || 'light') === 'dark' ? 'light' : 'dark';
                        window.applyAdminTheme(nextTheme);
                    });
                });
            });
        })();

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
