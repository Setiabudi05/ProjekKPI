<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .text-center { text-align: center; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f2f2f2; }
        .bg-hadir { color: green; font-weight: bold; }
        .bg-tidak-hadir { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header text-center">
        <h2 style="margin:0;">LAPORAN DETAIL KEHADIRAN PESERTA MAGANG</h2>
        <p style="margin:5px 0;">Periode: {{ $periodeLabel }}</p>
    </div>

    @foreach($reports as $intern)
    <div style="margin-top: 20px;">
        <strong>Nama Peserta:</strong> {{ $intern->name }} <br>
        <strong>Sekolah/Instansi:</strong> {{ $intern->school }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Hari</th>
                <th width="20%">Tanggal</th>
                <th>Status Kehadiran (Hadir/Izin/Sakit/Alpha)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($intern->attendances as $index => $atd)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                {{-- Mengonversi tanggal ke nama Hari dalam bahasa Indonesia --}}
                <td class="text-center">{{ \Carbon\Carbon::parse($atd->date)->translatedFormat('l') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($atd->date)->format('d-m-Y') }}</td>
                <td class="text-center {{ $atd->status == 'Hadir' ? 'bg-hadir' : 'bg-tidak-hadir' }}">
                    {{ $atd->status }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data absensi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <hr style="border: 0.5px dashed #ccc;">
    @endforeach

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
        <br><br>
        <p><strong>( Admin Utama )</strong></p>
    </div>
</body>
</html>