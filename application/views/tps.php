<table class="table striped demo1">
	<thead>
		<tr>
			<th>TPS</th>
			<th>Pemilih</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($tps as $row) {
				echo "<tr>";
					echo "<td> <center> <a href='".base_url('pemilih/index/').$row['nama']."/0' > ".$row['nama']." </a> </center></td>";
					echo "<td>".$row['jPemilih']."</td>";
				echo "</tr>";
			}
		?>
		<tr>
			
		</tr>
	</tbody>
</table>

<?php echo $paginator; ?>