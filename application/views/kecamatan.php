<table class="table striped demo1">
	<thead>
		<tr>
			<th>Kecamatan</th>
			<th>Kelurahan</th>
			<th>TPS</th>
			<th>Pemilih</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($kecamatan as $row) {
				echo "<tr>";
					echo "<td> <a href='".base_url('kelurahan/index/').$row['id']."/0' > ".$row['nama']." </a> </td>";
					echo "<td> <a href='".base_url('kelurahan/index/').$row['id']."/0' > ".$row['jKelurahan']." </a> </td>";
					echo "<td>".$row['jTps']."</td>";
					echo "<td>".$row['jPemilih']."</td>";
				echo "</tr>";
			}
		?>
		<tr>
			
		</tr>
	</tbody>
</table>

  <?php echo $paginator; ?>