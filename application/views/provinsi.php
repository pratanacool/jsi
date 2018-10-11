<table class="table striped demo1">
	<thead>
		<tr>
			<th data-field="id">Provinsi</th>
			<th>Kabupaten / Kota</th>
			<th>Kecamatan</th>
			<th>Kelurahan</th>
			<!-- <th>TPS</th> -->
			<th>Pemilih</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($provinsi as $row) {
				echo "<tr>";
					echo "<td> <a href='".base_url('kota/index/').$row['id']."/0' >".$row['nama']."</a> </td>";
					echo "<td> <a href='".base_url('kota/index/').$row['id']."/0' >".$row['jKota']."</a> </td>";
					echo "<td>".$row['jKecamatan']."</td>";
					echo "<td>".$row['jKelurahan']."</td>";
					// echo "<td>".$row['jTps']."</td>";
					echo "<td>".$row['jPemilih']."</td>";
				echo "</tr>";
			}
		?>
		<tr>
			
		</tr>
	</tbody>
</table>

  <?php echo $paginator; ?>