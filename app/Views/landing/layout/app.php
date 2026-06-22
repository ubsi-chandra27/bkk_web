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
            text-align: left;
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

        // Safe KTMenu init
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof KTMenu !== 'undefined') {
                try {
                    KTMenu.createInstances('[data-kt-menu="true"]');
                } catch (e) {}
            }
        });
    </script>

    <script>
        // Notification System for Landing (Pelamar)
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
                if (notif.type === 'new_application') return 'Lamaran terkirim';
                if (notif.type === 'status_changed') return 'Status lamaran';
                if (notif.type === 'new_user') return 'Pendaftar baru';
                if (notif.type === 'tracer_study_submitted') return 'Tracer study baru';
                return compactText(notif.title || 'Notifikasi', 42);
            }

            function notificationMessage(notif) {
                const message = String(notif.message || '');
                let match = message.match(/^(.+?) melamar posisi (.+)$/i);

                if (match) {
                    return compactText(match[2], 58);
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
                const listEl = document.getElementById('notification-list-landing');
                const countEl = document.getElementById('notif-count-landing');
                const emptyEl = document.getElementById('notif-empty-landing');
                const badgeEl = document.getElementById('notification-badge-landing');

                if (countEl) countEl.textContent = notifs.length;

                if (notifs.length === 0) {
                    if (listEl) listEl.innerHTML = '<div class="text-center text-muted py-10" id="notif-empty-landing">Tidak ada notifikasi</div>';
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

            document.addEventListener('DOMContentLoaded', function() {
                // Only initialize for pelamar/alumni
                <?php if (in_array(session()->get('id_role') ?? 0, [4, 5])): ?>
                    // Polling every 10 seconds
                    fetchNotifications();
                    pollInterval = setInterval(fetchNotifications, 10000);

                    const markAllBtn = document.getElementById('mark-all-read');
                    if (markAllBtn) {
                        markAllBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            markAllRead();
                        });
                    }

                    // Handle notification click
                    document.addEventListener('click', function(e) {
                        const link = e.target.closest('.notif-link');
                        if (link) {
                            e.preventDefault();
                            const notifEl = link.closest('[data-notif-id]');
                            const notifId = notifEl ? notifEl.getAttribute('data-notif-id') : null;
                            const notifUrl = notifEl ? notifEl.getAttribute('data-notif-url') : null;
                            let targetUrl = notifUrl;

                            if (!targetUrl && notifId) {
                                const found = notificationsCache.find(function(n) {
                                    return n.id == notifId;
                                });
                                if (found && found.url) {
                                    targetUrl = found.url;
                                }
                            }

                            targetUrl = targetUrl || '<?= site_url('profil') ?>#tab_lamaran';

                            if (notifId) {
                                markOneAndRedirect(notifId, targetUrl);
                            } else {
                                window.location.href = targetUrl;
                            }
                        }
                    });
                <?php endif; ?>
            });
        })();
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>
