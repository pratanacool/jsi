<?php if($this->session->flashdata('success')){ ?>
	<div id="card-alert" class="card green lighten-5">
	  <div class="card-content green-text">
	    <p><?php echo $this->session->flashdata('success'); ?></p>
	  </div>
	  <button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">×</span>
	  </button>
	</div>

<?php }else if($this->session->flashdata('failed')){  ?>
	<div id="card-alert" class="card red lighten-5">
	  <div class="card-content red-text">
	    <p><?php echo $this->session->flashdata('failed'); ?></p>
	  </div>
	  <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">×</span>
	  </button>
	</div>
<?php } ?>

<table id="data-table-row-grouping" class="display" cellspacing="0" width="100%">
  <thead>
      <tr>
		<th>NIK</th>
		<th>Nama</th>
		<th>TPS</th>
		<th>Tempat Lahir</th>
		<th>Tanggal Lahir</th>
		<th>Gender</th>
		<th>Action</th>
      </tr>
  </thead>

  <tbody>
	<?php
		foreach ($pemilih as $row) {
			echo "<tr>";
				echo "<td id='nik$row->id'>".$row->nik."</td>";
				echo "<td id='nama$row->id'>".$row->nama."</td>";
				echo "<td>TPS".$row->tps."</td>";
				echo "<td id='tempatLahir$row->id'>".$row->tempat_lahir."</td>";
				echo "<td id='tglLahir$row->id'>".$row->tanggal_lahir."</td>";
				echo "<td id='gender$row->id'>".$row->gender."</td>";
				echo "<td>";
					echo "<a class='btn-floating waves-effect waves-light tooltipped modal-trigger orange' data-tooltip='Edit data pemilih' href='#modal2' onclick='edit($row->id)'><i class='mdi-editor-mode-edit' alt='edit'></i></a> | "; 
					echo "<a class='btn-floating waves-effect waves-light tooltipped blue' data-tooltip='Interview pemilih' onclick='edit($row->id)'><i class='mdi-action-assignment'></i></a>";
				echo "</td>";
			echo "</tr>";
		}
	?>      	
  </tbody>
</table>

<!-- modal form -->
            
    <div id="modal2" class="modal modal-fixed-footer">
		<form action="<?php echo base_url();?>pemilih/simpan" method="POST" id="formKu" enctype="multipart/form-data">
		<div class="modal-content">

			<h4 class="header2">Data Pemilih</h4>
			<input id="id" name="id" type="hidden" >
			<div class="row">
				<div class="input-field col s12">
					<input id="nik" name="nik" type="text">
					<label for="nik" id="lnik">NIK</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<input id="nama" name="nama" type="text">
					<label for="nama" id="lnama">Nama</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<input id="tempatLahir" name="tempatLahir" type="text">
					<label for="tempatLahir" id="ltempatLahir">Tempat Lahir</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<input id="tanggalLahir" name="tanggalLahir" type="date" class="datepicker">
					<label for="tanggalLahir" id="ltanggalLahir">Tanggal Lahir</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					Gender : <br>
					<div class="switch">
						<label  style="margin-top: 18px">
	                      L
	                      <input type="checkbox" name="gender" id="gender" value="P">
	                      <span class="lever"></span> P
	                    </label>
	                </div>
					
				</div>
			</div>


		</div>

		<div class="modal-footer">
			<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Simpan <i class="mdi-content-send right"></i> </button>

			<a href="#" class="btn red waves-effect waves-light right modal-action modal-close">Batal <i class="mdi-content-clear right"></i></a>
		</div>
      </form>
    </div>

<!-- /modal form -->

<script type="text/javascript">
	window.setTimeout(function() {
	    $("#card-alert").fadeTo(500, 0).slideUp(500, function(){
	        $(this).remove(); 
	    });
	}, 6000);

	$(document).ready(function(){
		$('.tooltipped').tooltip({delay: 50});

		$('.datepicker').pickadate({
          format: 'yyyy-mm-dd',
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 25 // Creates a dropdown of 15 years to control year
        });
	});

	function edit(id) {
		var nik = $("#nik"+id).text();
		var nama = $("#nama"+id).text();
		var tempatLahir = $("#tempatLahir"+id).text();
		var tglLahir = $("#tglLahir"+id).text();
		var gender = $("#gender"+id).text();

		$("#id").val(id);
		$("#nik").val(nik);
		$("#lnik").addClass("active"); 

		$("#nama").val(nama); 
		$("#lnama").addClass("active");

		$("#tempatLahir").val(tempatLahir); 
		$("#ltempatLahir").addClass("active");

		$("#tanggalLahir").val(tglLahir);
		$("#ltanggalLahir").addClass("active");

		if (gender == "P") {
			$("#gender").prop('checked', true);
		} 
	}


</script>