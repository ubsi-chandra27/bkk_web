<?php

namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportAlumniExcel
{
    private const BASE_COLUMNS = [
        'No' => null,
        'Nama' => 'nama',
        'NIS' => 'nis',
        'NISN' => 'nisn',
        'No Ijazah' => 'no_ijazah',
        'Jurusan' => 'nama_jurusan',
        'Angkatan' => 'nama_angkatan',
        'Aktivitas' => 'nama_aktivitas',
    ];

    private const ACTIVITY_COLUMNS = [
        'BEKERJA' => [
            'Posisi Kerja' => 'posisi_kerja',
            'Nama DU/DI' => 'nama_dudi',
            'Bidang DU/DI' => 'bidang_dudi',
            'Alamat DU/DI' => 'alamat_dudi',
            'Tahun Mulai Kerja' => 'tahun_mulai_kerja',
            'Relevan dengan Jurusan' => 'is_relevan_jurusan',
            'Penghasilan' => 'penghasilan_range',
        ],
        'KULIAH' => [
            'Universitas' => 'universitas',
            'Program Studi' => 'program_studi',
            'Status Kuliah' => 'status_kuliah',
        ],
        'WIRAUSAHA' => [
            'Nama Usaha' => 'nama_usaha',
            'Bidang Usaha' => 'bidang_usaha',
            'Modal Awal' => 'modal_awal',
            'Penghasilan Usaha' => 'penghasilan_usaha',
        ],
        'BERENCANA KULIAH' => [
            'Rencana Universitas' => 'rencana_universitas',
            'Rencana Prodi' => 'rencana_prodi',
        ],
        'MENCARI KERJA' => [],
    ];

    public function generate(array $data, array $filters, array $jurusanList, array $angkatanList): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Alumni');

        $maxColumnCount = count(self::BASE_COLUMNS) + count(self::ACTIVITY_COLUMNS['BEKERJA']);
        $maxColumnLetter = Coordinate::stringFromColumnIndex($maxColumnCount);

        $sheet->mergeCells("A1:{$maxColumnLetter}1");
        $sheet->setCellValue('A1', 'Laporan Data Alumni');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells("A2:{$maxColumnLetter}2");
        $sheet->setCellValue('A2', $this->buildFilterSummary($filters, $jurusanList, $angkatanList));
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->freezePane('A4');

        $groups = $this->groupByActivity($data);
        $row = 4;

        foreach ($groups as $activityName => $items) {
            if ($items === []) {
                continue;
            }

            $activityKey = $this->activityKey($activityName);
            $columns = self::BASE_COLUMNS + (self::ACTIVITY_COLUMNS[$activityKey] ?? []);
            $lastColumnLetter = Coordinate::stringFromColumnIndex(count($columns));

            $sheet->mergeCells("A{$row}:{$maxColumnLetter}{$row}");
            $sheet->setCellValue("A{$row}", '■ ' . strtoupper($activityName) . ' (' . count($items) . ' siswa)');
            $sheet->getStyle("A{$row}:{$maxColumnLetter}{$row}")->applyFromArray($this->sectionHeaderStyle());
            $row++;

            $columnIndex = 1;
            foreach (array_keys($columns) as $heading) {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($columnIndex) . $row, $heading);
                $columnIndex++;
            }

            $sheet->getStyle("A{$row}:{$lastColumnLetter}{$row}")->applyFromArray($this->tableHeaderStyle());
            $row++;

            $number = 1;
            foreach ($items as $item) {
                $columnIndex = 1;

                foreach ($columns as $field) {
                    $cell = Coordinate::stringFromColumnIndex($columnIndex) . $row;
                    $value = $field === null ? $number : $this->formatValue($field, $item[$field] ?? null);

                    if (in_array($field, ['nis', 'nisn', 'no_ijazah'], true)) {
                        $sheet->setCellValueExplicit($cell, $value, DataType::TYPE_STRING);
                    } else {
                        $sheet->setCellValue($cell, $value);
                    }

                    $columnIndex++;
                }

                $fillColor = $number % 2 === 0 ? 'F5F5F5' : 'FFFFFF';
                $sheet->getStyle("A{$row}:{$lastColumnLetter}{$row}")->applyFromArray($this->dataRowStyle($fillColor));
                $row++;
                $number++;
            }

            $row += 2;
        }

        for ($columnIndex = 1; $columnIndex <= $maxColumnCount; $columnIndex++) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($columnIndex))->setAutoSize(true);
        }

        return $spreadsheet;
    }

    private function groupByActivity(array $data): array
    {
        $groups = [];

        foreach ($data as $row) {
            $activity = trim((string) ($row['nama_aktivitas'] ?? 'Tanpa Aktivitas'));
            $groups[$activity !== '' ? $activity : 'Tanpa Aktivitas'][] = $row;
        }

        ksort($groups, SORT_NATURAL | SORT_FLAG_CASE);

        return $groups;
    }

    private function buildFilterSummary(array $filters, array $jurusanList, array $angkatanList): string
    {
        $jurusan = $this->findLabel($jurusanList, $filters['id_jurusan'] ?? null, ['nama_jurusan', 'kompetensi_keahlian', 'akronim'], 'Semua Jurusan');
        $angkatan = $this->findLabel($angkatanList, $filters['id_angkatan'] ?? null, ['nama_angkatan', 'tahun'], 'Semua Angkatan');
        $aktivitas = $this->activityLabel($filters['id_aktivitas'] ?? null);

        return sprintf(
            'Jurusan: %s | Angkatan: %s | Aktivitas: %s | Diekspor: %s',
            $jurusan,
            $angkatan,
            $aktivitas,
            date('d/m/Y H:i:s')
        );
    }

    private function findLabel(array $items, mixed $id, array $labelKeys, string $default): string
    {
        if (empty($id)) {
            return $default;
        }

        foreach ($items as $item) {
            if ((string) ($item['id'] ?? '') !== (string) $id) {
                continue;
            }

            foreach ($labelKeys as $key) {
                if (! empty($item[$key])) {
                    return (string) $item[$key];
                }
            }
        }

        return $default;
    }

    private function activityLabel(mixed $id): string
    {
        return [
            '1' => 'Bekerja',
            '2' => 'Kuliah',
            '3' => 'Wirausaha',
            '4' => 'Mencari Kerja',
            '5' => 'Berencana Kuliah',
        ][(string) $id] ?? 'Semua Aktivitas';
    }

    private function activityKey(string $activityName): string
    {
        $activityName = strtoupper(trim($activityName));

        if (str_contains($activityName, 'BERENCANA')) {
            return 'BERENCANA KULIAH';
        }

        if (str_contains($activityName, 'MENCARI')) {
            return 'MENCARI KERJA';
        }

        if (str_contains($activityName, 'WIRAUSAHA')) {
            return 'WIRAUSAHA';
        }

        if (str_contains($activityName, 'KULIAH')) {
            return 'KULIAH';
        }

        return 'BEKERJA';
    }

    private function formatValue(string $field, mixed $value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        if ($field === 'is_relevan_jurusan') {
            return (int) $value === 1 ? 'Ya' : 'Tidak';
        }

        if ($field === 'modal_awal') {
            return 'Rp ' . number_format((float) $value, 0, ',', '.');
        }

        return (string) $value;
    }

    private function sectionHeaderStyle(): array
    {
        return [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '263238'],
            ],
        ];
    }

    private function tableHeaderStyle(): array
    {
        return [
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E88E5'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9D9D9'],
                ],
            ],
        ];
    }

    private function dataRowStyle(string $fillColor): array
    {
        return [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $fillColor],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9D9D9'],
                ],
            ],
        ];
    }
}
