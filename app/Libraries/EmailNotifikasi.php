<?php

namespace App\Libraries;

class EmailNotifikasi
{
    public function kirimStatusLamaran(int $idLamaran, string $status, ?string $tanggalWawancara = null): bool
    {
        $lamaran = $this->getDetailLamaran($idLamaran);

        if (!$lamaran || empty($lamaran['email'])) {
            log_message('error', 'Email status lamaran gagal: email pelamar tidak ditemukan untuk lamaran ID ' . $idLamaran);
            return false;
        }

        $email = \Config\Services::email();
        $message = $this->buatPesan($status, $lamaran, $tanggalWawancara);

        $email->setTo($lamaran['email']);
        $email->setSubject($message['subject']);
        $email->setMessage($message['body']);

        if (!$email->send()) {
            log_message('error', 'Email status lamaran gagal dikirim untuk lamaran ID ' . $idLamaran . ': ' . print_r($email->printDebugger(['headers']), true));
            return false;
        }

        return true;
    }

    private function getDetailLamaran(int $idLamaran): ?array
    {
        $db = \Config\Database::connect();

        return $db->table('tb_lamaran')
            ->select('tb_lamaran.*, tb_users.nama as nama_pelamar, tb_users.email, tb_lowongan.posisi, tb_perusahaan.nama_perusahaan')
            ->join('tb_pelamar', 'tb_pelamar.id = tb_lamaran.id_pelamar', 'left')
            ->join('tb_users', 'tb_users.id = tb_pelamar.id_user', 'left')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan', 'left')
            ->join('tb_perusahaan', 'tb_perusahaan.id = tb_lowongan.id_perusahaan', 'left')
            ->where('tb_lamaran.id', $idLamaran)
            ->get()
            ->getRowArray();
    }

    private function buatPesan(string $status, array $lamaran, ?string $tanggalWawancara): array
    {
        $nama = esc($lamaran['nama_pelamar'] ?? 'Pelamar');
        $posisi = esc($lamaran['posisi'] ?? '-');
        $perusahaan = esc($lamaran['nama_perusahaan'] ?? '-');
        $tanggal = $tanggalWawancara ? date('d/m/Y', strtotime($tanggalWawancara)) : '-';

        if ($status === 'wawancara') {
            return [
                'subject' => 'Jadwal Wawancara Lamaran Kerja',
                'body' => "
                    <p>Halo {$nama},</p>
                    <p>Status lamaran Anda untuk posisi <strong>{$posisi}</strong> di <strong>{$perusahaan}</strong> telah masuk tahap wawancara.</p>
                    <p>Jadwal wawancara: <strong>{$tanggal}</strong>.</p>
                    <p>Silakan mempersiapkan diri dan mengikuti informasi lanjutan dari pihak BKK atau perusahaan.</p>
                    <p>Terima kasih.</p>
                ",
            ];
        }

        if ($status === 'diterima') {
            return [
                'subject' => 'Selamat, Lamaran Anda Diterima',
                'body' => "
                    <p>Halo {$nama},</p>
                    <p>Selamat, lamaran Anda untuk posisi <strong>{$posisi}</strong> di <strong>{$perusahaan}</strong> dinyatakan <strong>diterima</strong>.</p>
                    <p>Informasi lanjutan akan disampaikan oleh pihak BKK atau perusahaan.</p>
                    <p>Terima kasih.</p>
                ",
            ];
        }

        return [
            'subject' => 'Pemberitahuan Status Lamaran Kerja',
            'body' => "
                <p>Halo {$nama},</p>
                <p>Terima kasih atas minat dan waktu yang telah Anda berikan untuk melamar posisi <strong>{$posisi}</strong> di <strong>{$perusahaan}</strong>.</p>
                <p>Dengan hormat kami sampaikan bahwa saat ini lamaran Anda belum dapat kami lanjutkan ke tahap berikutnya.</p>
                <p>Semoga sukses untuk kesempatan berikutnya.</p>
                <p>Terima kasih.</p>
            ",
        ];
    }
}
