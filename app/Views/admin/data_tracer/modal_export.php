<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalExportAlumni">
    <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
</button>

<div class="modal fade" id="modalExportAlumni" tabindex="-1" aria-labelledby="modalExportAlumniLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="get" action="<?= base_url('admin/data-tracer/export-excel') ?>" data-export-alumni-form>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExportAlumniLabel">Export Data Alumni ke Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-5">
                        <label for="export_id_jurusan" class="form-label">Jurusan</label>
                        <select id="export_id_jurusan" name="id_jurusan" class="form-select" data-control="select2" data-dropdown-parent="#modalExportAlumni">
                            <option value="">Semua Jurusan</option>
                            <?php foreach ($jurusanList as $jurusan): ?>
                                <option value="<?= esc($jurusan['id']) ?>"><?= esc($jurusan['nama_jurusan'] ?? $jurusan['kompetensi_keahlian'] ?? $jurusan['akronim'] ?? '-') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="export_id_angkatan" class="form-label">Angkatan</label>
                        <select id="export_id_angkatan" name="id_angkatan" class="form-select" data-control="select2" data-dropdown-parent="#modalExportAlumni">
                            <option value="">Semua Angkatan</option>
                            <?php foreach ($angkatanList as $angkatan): ?>
                                <option value="<?= esc($angkatan['id']) ?>"><?= esc($angkatan['nama_angkatan'] ?? $angkatan['tahun'] ?? '-') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="export_id_aktivitas" class="form-label">Aktivitas</label>
                        <select id="export_id_aktivitas" name="id_aktivitas" class="form-select" data-control="select2" data-dropdown-parent="#modalExportAlumni">
                            <option value="">Semua Aktivitas</option>
                            <option value="1">Bekerja</option>
                            <option value="2">Kuliah</option>
                            <option value="3">Wirausaha</option>
                            <option value="4">Mencari Kerja</option>
                            <option value="5">Berencana Kuliah</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" data-export-submit>
                        <span class="indicator-label">Download Excel</span>
                        <span class="indicator-progress">Memproses...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.querySelector('[data-export-alumni-form]');

        if (!form) {
            return;
        }

        form.addEventListener('submit', function () {
            var button = form.querySelector('[data-export-submit]');

            if (button) {
                button.setAttribute('data-kt-indicator', 'on');
                button.disabled = true;

                window.setTimeout(function () {
                    button.removeAttribute('data-kt-indicator');
                    button.disabled = false;
                }, 3000);
            }
        });
    });
</script>
