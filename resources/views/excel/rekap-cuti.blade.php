<table>
    <thead>
    <tr>
        <th colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">
            Laporan Rekapitulasi Cuti Pegawai
        </th>
    </tr>
    <tr>
        <th colspan="9" style="text-align: center; font-size: 12px;">
            {{ $periodLabel }}
        </th>
    </tr>
    <tr></tr> <!-- Empty Row -->
    
    <!-- Statistics Summary -->
    <tr>
        <th colspan="2" style="font-weight: bold;">Ringkasan Statistik:</th>
    </tr>
    <tr>
        <td>Total Pegawai:</td>
        <td>{{ $statistics['total_employees'] }}</td>
    </tr>
    <tr>
        <td>Total Pengajuan:</td>
        <td>{{ $statistics['total_requests'] }}</td>
    </tr>
    <tr>
        <td>Cuti Disetujui:</td>
        <td>{{ $statistics['total_approved'] }}</td>
    </tr>
    <tr>
        <td>Total Hari Cuti:</td>
        <td>{{ $statistics['total_leave_days'] }} Hari</td>
    </tr>
    <tr></tr> <!-- Empty Row -->

    <!-- Table Headers -->
    <tr>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">No</th>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">NIP</th>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">Nama Pegawai</th>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">Jabatan</th>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">Total Request</th>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">Disetujui</th>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">Menunggu</th>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">Ditolak</th>
        <th style="background-color: #4F46E5; color: #FFFFFF; font-weight: bold; text-align: center; border: 1px solid #000000;">Total Hari Cuti</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $index => $row)
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000000; text-align: left;">{{ $row['nip'] }}</td>
            <td style="border: 1px solid #000000; font-weight: bold;">{{ $row['name'] }}</td>
            <td style="border: 1px solid #000000;">{{ $row['jabatan'] }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $row['total_requests'] }}</td>
            <td style="border: 1px solid #000000; text-align: center; color: #16A34A;">{{ $row['approved'] }}</td>
            <td style="border: 1px solid #000000; text-align: center; color: #CA8A04;">{{ $row['pending'] }}</td>
            <td style="border: 1px solid #000000; text-align: center; color: #DC2626;">{{ $row['rejected'] }}</td>
            <td style="border: 1px solid #000000; text-align: center; font-weight: bold;">{{ $row['total_days'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
