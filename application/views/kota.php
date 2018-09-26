<table class="table striped demo1">
	<thead>
		<tr>
			<th>Kabupaten / Kota</th>
			<th>Kecamatan</th>
			<th>Kelurahan</th>
			<th>TPS</th>
			<th>Pemilih</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($kota as $row) {
				echo "<tr>";
					echo "<td> <a href='".base_url('kecamatan/index/').$row['id']."/0' > ".$row['nama']."</a> </td>";
					echo "<td> <a href='".base_url('kecamatan/index/').$row['id']."/0' > ".$row['jKecamatan']."</a> </td>";
					echo "<td>".$row['jKelurahan']."</td>";
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
   <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins/jquery-1.11.2.min.js"></script>    