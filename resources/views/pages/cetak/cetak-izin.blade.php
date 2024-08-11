<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin Peserta Magang</title>
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
        <h3 align="center">Izin Peserta Magang</h3>
        <div>
            <li><b>Nama </b>: <span style="margin-left:10px;">{{ $permission[0]->user->name }}</span></li>
            <li><b>Asal Sekolah </b>: <span style="margin-left:10px;">{{ $permission[0]->user->sekolah }}</span></li>
        </div>
        <button class="print-button" onclick="printPage()">Cetak Izin</button>

        <table align="center">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Tanggal</th>
                    <th style="text-align: center;">Alasan</th>
                    <th style="text-align: center;">Bukti Dukung</th>
                </tr>
            </thead>

            <tbody>
                @php
                $currentNo = 0;
                $recentDate = "";
                $rowSpanCounter = 0;
                @endphp
                @foreach($permission as $index => $item)
                <tr>
                    @if (($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') != $recentDate)
                    @php
                    $currentNo++;
                    $rowSpanCounter = $permission->where('created_at', '!=', null)->where('created_at', '>=', $item->created_at->startOfDay())->where('created_at', '<=', $item->created_at->endOfDay())->count();
                        @endphp
                        <td style="text-align: center;" rowspan="{{ $rowSpanCounter }}">{{ $currentNo }}</td>
                        <td rowspan="{{ $rowSpanCounter }}">{{ ($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                        @else
                        @endif

                        @php
                        $recentDate = ($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY');
                        @endphp
                        <td>{{ $item->reason }}</td>
                        <td>
                            @if ($item->image)
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ asset('storage/permissions/' . $item->image) }}" alt="Gambar tidak tersedia" width="60" style="display: block; margin: 0 auto;">
                            @else
                            Gambar tidak tersedia
                            @endif
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function printPage() {
            window.print();
        }
    </script>

</body>

</html>