<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>

    <style type="text/css">
        .line-tittle {
            border: 0;
            border-style: unset;
            border-top: 1px solid #000;
        }

        .table {
            width: 100%;
            border-spacing: 0;
        }

        .table tr:first-child th,
        .table tr:first-child td {
            border-top: 1px solid #000;
        }

        .table tr th:first-child,
        .table tr td:first-child {
            border-left: 1px solid #000;
        }

        .table tr th,
        .table tr td {
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 4px;
        }
    </style>
</head>

<body>
    <h3>Data Kegiatan</h3>
    <table class="table border=" 1" cellpadding="8"">
	<tr>
		<th>No.</th>
		<th>Kode</th>
		<th>Nama Kegiatan</th>
		<th>Tanggal</th>
		<th>Waktu</th>
		<th>Tempat</th>
		<th>Pegawai</th>
	</tr>
	<?php if (!empty($kegiatan)) : ?>
		<?php foreach ($kegiatan as $data) : ?>
			<tr>
				<td><?php echo $data->id++; ?></td>
				<td><?php echo $data->kode; ?></td>
				<td><?php echo $data->nama; ?></td>
				<td><?php echo $data->tanggal; ?></td>
				<td><?php echo $data->waktu; ?></td>
				<td><?php echo $data->tempat; ?></td>
				<td><?php echo $data->pegawai; ?></td>
			</tr>
		<?php endforeach; ?>
	<?php else : ?>
		<tr>
			<td colspan=" 7">Data tidak ada</td>
        </tr>
    <?php endif; ?>
    </table>
</body>

</html>