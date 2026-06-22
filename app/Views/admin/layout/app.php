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

        .notification-dot {
            top: 8px;
            right: 7px;
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #f1416c;
            border: 2px solid #fff;
        }

        .notification-menu {
            border: 1px solid #edf2f7;
            border-radius: 8px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            text-align: left;
        }

        .notification-menu-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px 14px;
            border-bottom: 1px solid #edf2f7;
            background: #fff;
        }

        .notification-title {
            color: #1f2937;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.2;
        }

        .notification-subtitle {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 600;
            margin-top: 3px;
        }

        .notification-clear {
            border: 0;
            background: transparent;
            color: #3b82f6;
            font-size: 12px;
            font-weight: 700;
            padding: 0;
        }

        .notification-list {
            padding: 8px;
            background: #fff;
        }

        .notification-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 8px;
            transition: background 0.16s ease, transform 0.16s ease;
        }

        .notification-item:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 36px;
        }

        .notification-icon-success {
            background: #ecfdf3;
            color: #16a34a;
        }

        .notification-icon-warning {
            background: #fff7ed;
            color: #ea580c;
        }

        .notification-icon-info {
            background: #f1faff;
            color: #009ef7;
        }

        .notification-icon-primary {
            background: #f8f5ff;
            color: #7239ea;
        }

        .notification-content {
            min-width: 0;
        }

        .notification-link {
            display: block;
            color: #1f2937;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.35;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notification-message {
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.35;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 2px;
        }

        .notification-time {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
            margin-top: 4px;
        }

        body[data-admin-theme="dark"] .notification-menu,
        body[data-admin-theme="dark"] .notification-menu-head,
        body[data-admin-theme="dark"] .notification-list {
            background: #0f172a;
            border-color: rgba(148, 163, 184, 0.16);
        }

        body[data-admin-theme="dark"] .notification-title,
        body[data-admin-theme="dark"] .notification-link {
            color: #e5e7eb !important;
        }

        body[data-admin-theme="dark"] .notification-message,
        body[data-admin-theme="dark"] .notification-subtitle,
        body[data-admin-theme="dark"] .notification-time {
            color: #94a3b8 !important;
        }

        body[data-admin-theme="dark"] .notification-item:hover {
            background: #1e293b;
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

        body[data-admin-theme="dark"] .table> :not(caption)>*>* {
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

        .stat-card-custom {
            border-radius: 14px !important;
            border: 0.5px solid #e9ecef !important;
            transition: transform 0.22s cubic-bezier(.22, .68, 0, 1.2), box-shadow 0.22s !important;
            position: relative;
            overflow: hidden;
        }

        .stat-card-custom:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.09) !important;
        }

        .stat-card-custom .top-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3.5px;
        }

        .stat-card-custom .icon-box {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card-custom .stat-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 5px;
        }
    </style>
    <?= $this->renderSection('styles') ?>

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
        if (typeof window.initPasswordMeter !== 'function') {
            window.initPasswordMeter = function(inputId, progressId, textId, reqIds) {
                const input = document.getElementById(inputId);
                if (!input) return;

                const progress = document.getElementById(progressId);
                const textEl = document.getElementById(textId);

                function updateMeter() {
                    const password = input.value;
                    let score = 0;

                    if (password.length >= 8) score++;
                    if (/[A-Z]/.test(password)) score++;
                    if (/[a-z]/.test(password)) score++;
                    if (/[0-9]/.test(password)) score++;
                    if (/[^A-Za-z0-9]/.test(password)) score++;

                    const widths = [0, 20, 40, 60, 80, 100];
                    const colors = ['#e9ecef', '#f1416c', '#f1416c', '#ffc107', '#ffc107', '#50cd89'];
                    const labels = ['Belum diisi', 'Lemah', 'Lemah', 'Sedang', 'Sedang', 'Kuat'];
                    const labelClasses = ['text-muted', 'text-danger', 'text-danger', 'text-warning', 'text-warning', 'text-success'];

                    if (progress) {
                        progress.style.width = widths[score] + '%';
                        progress.style.backgroundColor = colors[score];
                    }

                    if (textEl) {
                        textEl.innerHTML = 'Kekuatan password: <span class="' + labelClasses[score] + '">' + labels[score] + '</span>';
                    }

                    reqIds.forEach(function(id) {
                        const el = document.getElementById(id);
                        if (!el) return;

                        let met = false;
                        if (id.includes('length') && password.length >= 8) met = true;
                        else if (id.includes('uppercase') && /[A-Z]/.test(password)) met = true;
                        else if (id.includes('lowercase') && /[a-z]/.test(password)) met = true;
                        else if (id.includes('number') && /[0-9]/.test(password)) met = true;
                        else if (id.includes('symbol') && /[^A-Za-z0-9]/.test(password)) met = true;

                        el.classList.toggle('text-success', met);
                        el.classList.toggle('text-muted', !met);

                        const icon = el.querySelector('i');
                        if (icon) {
                            icon.className = met ? 'bi bi-check-circle me-1' : 'bi bi-x-circle me-1';
                        }
                    });
                }

                input.addEventListener('input', updateMeter);
                updateMeter();
            };
        }

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

    <script>
        // Notification System
        (function() {
            const csrfToken = '<?= csrf_hash() ?>';
            let pollInterval;
            let notificationsCache = [];

            // Format waktu relatif dalam Bahasa Indonesia
            function timeAgo(dateString) {
                if (!dateString) {
                    return 'Baru saja';
                }

                const date = new Date(dateString);
                if (Number.isNaN(date.getTime())) {
                    return 'Baru saja';
                }

                const now = new Date();
                const diff = Math.max(0, now - date);
                const seconds = Math.floor(diff / 1000);
                const minutes = Math.floor(seconds / 60);
                const hours = Math.floor(minutes / 60);
                const days = Math.floor(hours / 24);

                if (days > 0) return days + ' hari yang lalu';
                if (hours > 0) return hours + ' jam yang lalu';
                if (minutes > 0) return minutes + ' menit yang lalu';
                return 'Baru saja';
            }

            function escapeHtml(value) {
                return String(value || '').replace(/[&<>"']/g, function(char) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    } [char];
                });
            }

            function compactText(value, limit) {
                const text = String(value || '').replace(/\s+/g, ' ').trim();
                return text.length > limit ? text.slice(0, limit - 1).trim() + '...' : text;
            }

            function notificationTitle(notif) {
                if (notif.type === 'new_application') return 'Lamaran baru';
                if (notif.type === 'status_changed') return 'Status lamaran';
                if (notif.type === 'new_user') return 'Pendaftar baru';
                if (notif.type === 'tracer_study_submitted') return 'Tracer study baru';
                return compactText(notif.title || 'Notifikasi', 42);
            }

            function notificationMessage(notif) {
                const message = String(notif.message || '');
                let match = message.match(/^(.+?) melamar posisi (.+)$/i);

                if (match) {
                    return compactText(match[1] + ' - ' + match[2], 58);
                }

                match = message.match(/untuk posisi (.+?) berubah menjadi:\s*(.+)$/i);

                if (match) {
                    return compactText(match[1] + ' - ' + match[2], 58);
                }

                return compactText(message, 58);
            }

            // Render notifikasi
            function renderNotifications(notifs) {
                notificationsCache = notifs;
                const listEl = document.getElementById('notification-list');
                const countEl = document.getElementById('notif-count');
                const emptyEl = document.getElementById('notif-empty');
                const badgeEl = document.getElementById('notification-badge');

                if (countEl) countEl.textContent = notifs.length;

                if (notifs.length === 0) {
                    if (listEl) listEl.innerHTML = '<div class="text-center text-muted py-10" id="notif-empty">Tidak ada notifikasi</div>';
                    if (badgeEl) badgeEl.style.display = 'none';
                    return;
                }

                if (badgeEl) badgeEl.style.display = 'block';

                let html = '';
                notifs.forEach(function(notif) {
                    const iconTone = {
                        new_application: 'notification-icon-success',
                        status_changed: 'notification-icon-warning',
                        new_user: 'notification-icon-info',
                        tracer_study_submitted: 'notification-icon-primary'
                    } [notif.type] || 'notification-icon-warning';
                    const iconClass = {
                        new_application: 'fa-briefcase',
                        status_changed: 'fa-clock',
                        new_user: 'fa-user-plus',
                        tracer_study_submitted: 'fa-file-lines'
                    } [notif.type] || 'fa-bell';

                    html += '<div class="notification-item" data-notif-id="' + escapeHtml(notif.id) + '" data-notif-url="' + escapeHtml(notif.url || '') + '">';
                    html += '<div class="notification-icon ' + iconTone + '">';
                    html += '<i class="fas ' + iconClass + ' fs-5"></i>';
                    html += '</div>';
                    html += '<div class="notification-content flex-grow-1">';
                    html += '<a href="javascript:;" class="notification-link notif-link">' + escapeHtml(notificationTitle(notif)) + '</a>';
                    html += '<div class="notification-message">' + escapeHtml(notificationMessage(notif)) + '</div>';
                    html += '<div class="notification-time">' + escapeHtml(timeAgo(notif.created_at)) + '</div>';
                    html += '</div></div>';
                });

                if (listEl) listEl.innerHTML = html;
            }

            // Fetch notifikasi
            function fetchNotifications() {
                fetch('<?= site_url('api/notifications') ?>', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data && data.notifications) {
                            renderNotifications(data.notifications);
                        }
                    })
                    .catch(function(err) {
                        console.error('Notification fetch error:', err);
                    });
            }

            // Mark all as read
            function markAllRead() {
                fetch('<?= site_url('api/notifications/read') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: '<?= csrf_token() ?>=' + csrfToken
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function() {
                        fetchNotifications();
                    })
                    .catch(function(err) {
                        console.error('Mark read error:', err);
                    });
            }

            // Mark one as read and redirect
            function markOneAndRedirect(notifId, url) {
                fetch('<?= site_url('api/notifications/read-one') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: 'id=' + notifId + '&<?= csrf_token() ?>=' + csrfToken
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function() {
                        if (url) window.location.href = url;
                    })
                    .catch(function(err) {
                        console.error('Mark one read error:', err);
                    });
            }

            // Event handlers
            document.addEventListener('DOMContentLoaded', function() {
                // Polling every 10 seconds
                fetchNotifications();
                pollInterval = setInterval(fetchNotifications, 10000);

                // Mark all read button
                const markAllBtn = document.getElementById('mark-all-read');
                if (markAllBtn) {
                    markAllBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        markAllRead();
                    });
                }

                // Handle notification click (delegation)
                document.addEventListener('click', function(e) {
                    const link = e.target.closest('.notif-link');
                    if (link) {
                        e.preventDefault();
                        const notifEl = link.closest('[data-notif-id]');
                        const notifId = notifEl ? notifEl.getAttribute('data-notif-id') : null;
                        const notifUrl = notifEl ? notifEl.getAttribute('data-notif-url') : null;

                        // Cari notifikasi di cache untuk mendapatkan url
                        let targetUrl = notifUrl;
                        if (!targetUrl && notifId) {
                            const found = notificationsCache.find(function(n) {
                                return n.id == notifId;
                            });
                            if (found && found.url) {
                                targetUrl = found.url;
                            }
                        }

                        // Default redirect berdasarkan role
                        <?php if (session()->get('id_role') != 4 && session()->get('id_role') != 5): ?>
                            targetUrl = targetUrl || '<?= site_url('admin/data-lamaran') ?>';
                        <?php else: ?>
                            targetUrl = targetUrl || '<?= site_url('profil') ?>#tab_lamaran';
                        <?php endif; ?>

                        if (notifId) {
                            markOneAndRedirect(notifId, targetUrl);
                        } else if (targetUrl) {
                            window.location.href = targetUrl;
                        }
                    }
                });
            });
        })();
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>
