<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Rekap Cuti Pegawai</title>
    <style>
        @page {
            margin: 1cm 1.5cm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 12pt;
            font-weight: normal;
        }
        .meta-info {
            margin-bottom: 20px;
            width: 100%;
        }
        .meta-info td {
            padding: 2px 0;
            vertical-align: top;
        }
        
        /* Summary Box */
        .summary-box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .summary-table {
            width: 100%;
        }
        .summary-table td {
            text-align: center;
            padding: 5px;
        }
        .summary-value {
            font-size: 14pt;
            font-weight: bold;
            display: block;
        }
        .summary-label {
            font-size: 8pt;
            text-transform: uppercase;
            color: #666;
        }

        /* Main Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ccc;
            padding: 8px 6px;
            text-align: left;
            vertical-align: middle;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
            text-align: center;
        }
        .table tr:nth-child(even) {
            background-color: #fbfbfb;
        }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .font-bold { font-weight: bold; }
        
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
        }
        .badge-success { color: #059669; background-color: #d1fae5; }
        .badge-warning { color: #d97706; background-color: #fef3c7; }
        .badge-danger { color: #dc2626; background-color: #fee2e2; }
        .badge-gray { color: #4b5563; background-color: #f3f4f6; }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Rekapitulasi Cuti Pegawai</h1>
        <h2>Sistem Informasi Cuti Pegawai</h2>
    </div>

    <table class="meta-info">
        <tr>
            <td width="15%"><strong>Periode Laporan</strong></td>
            <td width="2%">:</td>
            <td width="83%">{{ $periodLabel }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Cetak</strong></td>
            <td>:</td>
            <td>{{ now()->locale('id')->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td><strong>Dicetak Oleh</strong></td>
            <td>:</td>
            <td>{{ auth()->user()->name }}</td>
        </tr>
    </table>

    <!-- Executive Summary -->
    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td>
                    <span class="summary-value">{{ $statistics['total_employees'] }}</span>
                    <span class="summary-label">Total Pegawai</span>
                </td>
                <td style="border-left: 1px solid #ddd;">
                    <span class="summary-value">{{ $statistics['total_requests'] }}</span>
                    <span class="summary-label">Total Pengajuan</span>
                </td>
                <td style="border-left: 1px solid #ddd;">
                    <span class="summary-value" style="color: #059669;">{{ $statistics['total_approved'] }}</span>
                    <span class="summary-label">Disetujui</span>
                </td>
                <td style="border-left: 1px solid #ddd;">
                    <span class="summary-value" style="color: #d97706;">{{ $statistics['total_pending'] }}</span>
                    <span class="summary-label">Menunggu</span>
                </td>
                <td style="border-left: 1px solid #ddd;">
                    <span class="summary-value" style="color: #dc2626;">{{ $statistics['total_rejected'] }}</span>
                    <span class="summary-label">Ditolak</span>
                </td>
                <td style="border-left: 1px solid #ddd;">
                    <span class="summary-value">{{ $statistics['total_leave_days'] }}</span>
                    <span class="summary-label">Total Hari Cuti</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Main Data Table -->
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIP</th>
                <th width="25%">Nama Pegawai</th>
                <th width="15%">Jabatan</th>
                <th width="8%">Total<br>Pengajuan</th>
                <th width="8%">Setuju</th>
                <th width="8%">Pending</th>
                <th width="8%">Tolak</th>
                <th width="8%">Total<br>Hari</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $row['nip'] }}</td>
                    <td>
                        <span class="font-bold">{{ $row['name'] }}</span>
                    </td>
                    <td>{{ $row['jabatan'] ?? '-' }}</td>
                    <td class="text-center">{{ $row['total_requests'] }}</td>
                    <td class="text-center">
                        @if($row['approved'] > 0)
                            <span class="badge badge-success">{{ $row['approved'] }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($row['pending'] > 0)
                            <span class="badge badge-warning">{{ $row['pending'] }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($row['rejected'] > 0)
                            <span class="badge badge-danger">{{ $row['rejected'] }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center font-bold">{{ $row['total_days'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px; font-style: italic; color: #777;">
                        Tidak ada data cuti untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak otomatis oleh sistem.<br>WebCuti App v1.0</p>
    </div>

</body>
</html>