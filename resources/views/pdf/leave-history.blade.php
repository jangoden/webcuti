<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Cuti - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .user-info {
            margin-bottom: 20px;
        }
        .user-info table {
            width: 100%;
        }
        .user-info td {
            padding: 5px 0;
        }
        .user-info td:first-child {
            width: 150px;
            font-weight: bold;
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .history-table th,
        .history-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .history-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .history-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        .status-pending {
            color: #b45309;
            font-weight: bold;
        }
        .status-approved {
            color: #059669;
            font-weight: bold;
        }
        .status-rejected {
            color: #dc2626;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RIWAYAT CUTI PEGAWAI</h1>
        <p>Sistem Manajemen Cuti Pegawai</p>
    </div>

    <div class="user-info">
        <table>
            <tr>
                <td>Nama</td>
                <td>: {{ $user->name }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>: {{ $user->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: {{ $user->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Pegawai</td>
                <td>: {{ $user->jenis_pegawai ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jatah Cuti Tahunan</td>
                <td>: {{ $user->jumlah_cuti }} hari</td>
            </tr>
            <tr>
                <td>Sisa Cuti</td>
                <td>: {{ $user->getRemainingLeave() }} hari</td>
            </tr>
        </table>
    </div>

    <h3>Daftar Pengajuan Cuti</h3>

    @if ($leaveRequests->count() > 0)
        <table class="history-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Cuti</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Lama</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaveRequests as $index => $request)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $request->leaveType->name }}</td>
                        <td>{{ $request->start_date->format('d/m/Y') }}</td>
                        <td>{{ $request->end_date->format('d/m/Y') }}</td>
                        <td>{{ $request->total_days }} hari</td>
                        <td class="status-{{ $request->status }}">
                            @if ($request->status === 'pending')
                                Menunggu
                            @elseif ($request->status === 'approved')
                                Disetujui
                            @else
                                Ditolak
                            @endif
                        </td>
                        <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada riwayat pengajuan cuti.</p>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
