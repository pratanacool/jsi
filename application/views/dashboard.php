<table class="table">
	<thead>
		<tr>
			<th>Provinsi</th>
			<th>Kabupaten / Kota</th>
			<th>Kecamatan</th>
			<th>Kelurahan</th>
			<th>TPS</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($provinsi as $row) {
				echo "<tr>";
					echo "<td>".$row['nama']."</td>";
					echo "<td>".$row['jKota']."</td>";
					echo "<td>".$row['jKecamatan']."</td>";
					echo "<td>".$row['jKelurahan']."</td>";
					echo "<td>".$row['jTps']."</td>";
				echo "</tr>";
			}
		?>
		<tr>
			
		</tr>
	</tbody>
</table>

  <?php echo $paginator; ?>

<script type="text/javascript">
	$("#test").append("ada");
</script>