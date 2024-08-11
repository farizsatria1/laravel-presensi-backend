<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Peserta Magang</title>
    <style>
        h3 {
            margin-bottom: 50px;
        }

        li {
            display: table-row;
        }

        b {
            display: table-cell;
            padding-right: 1em;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            border: 1px solid black;
            text-align: left;
        }

        .print-button {
            background-color: transparent;
            border: 2px solid #007bff;
            color: #007bff;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 20px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .print-button:hover {
            background-color: #007bff;
            color: #fff;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="form-group">
        <h3 align="center">Presensi Peserta Magang</h3>
        <div>
            <li><b>Nama </b>: <span style="margin-left:10px;">{{ $presensi[0]->user->name }}</span></li>
            <li><b>Asal Sekolah </b>: <span style="margin-left:10px;">{{ $presensi[0]->user->sekolah }}</span></li>
        </div>
        <button class="print-button" onclick="printPage()">Cetak Presensi</button>

        <table align="center">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Tanggal</th>
                    <th style="text-align: center;">Waktu Masuk</th>
                    <th style="text-align: center;">Waktu Pulang</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>

            <tbody>
                @php
                $currentNo = 0;
                $recentDate = "";
                $rowSpanCounter = 0;
                @endphp
                @foreach($presensi as $index => $item)
                <tr>
                    @if (($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') != $recentDate)
                    @php
                    $currentNo++;
                    $rowSpanCounter = $presensi->where('created_at', '!=', null)->where('created_at', '>=', $item->created_at->startOfDay())->where('created_at', '<=', $item->created_at->endOfDay())->count();
                        @endphp
                        <td style="text-align: center;" rowspan="{{ $rowSpanCounter }}">{{ $currentNo }}</td>
                        <td rowspan="{{ $rowSpanCounter }}">{{ ($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                        @else
                        @endif

                        @php
                        $recentDate = ($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY');
                        @endphp
                        <td style="text-align: center;">{{ $item->time_in ?? '-'}}</td>
                        <td style="text-align: center;">{{ $item->time_out ?? '-'}}</td>
                        <td style="text-align: center;">
                            @if($item->status == 0)
                            Terlambat
                            @else
                            Tepat Waktu
                            @endif
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <p>Jumlah Presensi : {{ $presensi->where('time_in')->count() }} </p>
            <p>Jumlah Terlambat : {{ $presensi->where('status', 0)->count() }} </p>
        </div>
    </div>

    <script>
        function printPage() {
            window.print();
        }
    </script>

</body>

</html>