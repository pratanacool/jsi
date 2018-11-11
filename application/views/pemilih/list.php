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

<div class="row">
  <div class="col s12 m12 l12">
    <div class="card-panel">
      <div class="row">

        <form class="col s12" action="<?php echo base_url();?>pemilih/list" method="post">
        <!-- <div class="col s12"> -->
          <h4 class="header2">Filter</h4>
          <div class="row">

            <div class="input-field col s3">
              <?php
                echo form_dropdown('provinsi', $listProvinsi, $provinsi, 'id="provinsi"');
              ?>
              <label for="icon_prefix">Provinsi</label>
            </div>          

            <div class="input-field col s3">
              <input type="hidden" id="kotakabupatenx" value="<?php echo $kota; ?>">
              <select name="kota" id="kotakabupaten">
                <option value="">Pilih Kota / Kabupaten</option>
              </select>
              <label for="icon_prefix">Kabupaten / Kota</label>
            </div>

            <div class="input-field col s3">
              <input type="hidden" id="kecamatanx" value="<?php echo $kecamatan; ?>">
              <select name="kecamatan" id="kecamatan">
                <option value="">Pilih Kecamatan</option>
              </select>
              <label for="icon_prefix">Kecamatan</label>
            </div>

            <div class="input-field col s3">
              <input type="hidden" id="kelurahanx" value="<?php echo $kelurahan; ?>">
              <select name="kelurahan" id="kelurahan">
                <option value="">Pilih Kelurahan</option>
              </select>
              <label for="icon_prefix">Kelurahan</label>
            </div>
            
            <div class="input-field col s5">
              <input placeholder="Nama / NIk" type="text" name="search" value="<?php echo $search;?>">
              <label for="icon_email">Nama / Nik</label>
            </div>
            
            <div class="input-field col s1">
              <?php
                echo form_dropdown('limit', $listLimit, $limit);
              ?>
              <label for="icon_prefix">Banyak Data</label>
            </div>

            <div class="input-field col s2 offset-s4">
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right-align" type="submit" name="action" value="search"><i class="mdi-action-search"></i> Cari</button>
              </div>
            </div>

          </div>
        <!-- </div> -->
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="col s12 m12 l12">
    <div class="card-panel">
      <div class="row">          
        
        <code>Total Pemilih : <?php echo $totalData;?></code>
        <table id="table striped demo1">
            <thead>
              <tr>
                <th data-field="id">NIK</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>TPS</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
            <?php
              foreach ($pemilih as $row) {
                $id = $row['id'];
                echo "<tr>";
                  echo "<td id='nik{$id}'>".$row['nik']."</td>";
                  echo "<td id='nama{$id}'>".$row['nama']."</td>";
                  echo "<td id='tempatLahir{$id}'>".$row['tempat_lahir']."</td>";
                  echo "<td>".$row['nama_kecamatan']."</td>";
                  echo "<td>".$row['nama_kelurahan']."</td>";
                  echo "<td>TPS ".$row['tps']."</td>";
                  echo "<td>";
                    echo "<a class='btn-floating waves-effect waves-light tooltipped modal-trigger orange' data-tooltip='Edit data pemilih' href='#modalEdit' onclick='edit({$id})'><i class='mdi-editor-mode-edit' alt='edit'></i></a>"; 
                      if($row['memilih'] == null){
                        echo " | <a class='btn-floating waves-effect waves-light tooltipped modal-trigger blue' data-tooltip='Interview pemilih' onclick='edit({$id})' href='#modalInterview'><i class='mdi-action-assignment'></i></a>";
                      }
                  echo "</td>";
                echo "</tr>";
              }
            ?>        
            </tbody>
        </table>
      
        <?php echo $paginator; ?>
      
      </div>
    </div>
  </div>   
</div>

<!-- modal form -->
            
    <div id="modalEdit" class="modal modal-fixed-footer">
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
        </div>

        <div class="modal-footer">
          <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Simpan <i class="mdi-content-send right"></i> </button>

          <a href="#" class="btn red waves-effect waves-light right modal-action modal-close">Batal <i class="mdi-content-clear right"></i></a>
        </div>
      </form>
    </div>


    <div id="modalInterview" class="modal modal-fixed-footer">
      <form action="<?php echo base_url();?>pemilih/simpanInterview" method="POST" id="formKu" enctype="multipart/form-data">
        <div class="modal-content" id="konten">

          <h4 class="header2">Form Kuesioner</h4>
          <input id="id2" name="id" type="hidden">
          <input name="idCaleg" type="hidden" value="<?php echo idCaleg;?>">
          
          <div class="row" id="pertanyaan1">
            <div class='input-field col s12 m5'>  <input name='pertanyaan[]' type='text' value="Pilihan anda di pilleg" readonly="true"> <label for='pertanyaan' >Pertanyaan</label> </div>
            <div class='input-field col s12 m6'>
              <!-- <label>Pilihan anda</label> -->
                    <?php
                      echo form_dropdown('jawaban[]', $listPilihan,'id="pilihan"');
                    ?>
                </div>
          </div>


          <div class="row" id="pertanyaan4">
            <div class='input-field col s12 m5'>  <input name='pertanyaan[]' type='text' value="Tipe Pemilih" readonly="true"> <label for='pertanyaan' >Pertanyaan</label> </div>
            <div class='input-field col s12 m6'>
                    <?php
                      echo form_dropdown('jawaban[]', $listTipePemilih,'id="pemilih"');
                    ?>
                </div>
          </div>


          <div class="row" id="pertanyaan2">
            <div class='input-field col s12 m5'>  <input name='pertanyaan[]' type='text' value="Jumlah pemilih dalam satu rumah" readonly="true"> <label for='pertanyaan' >Pertanyaan</label> </div>
            <div class='input-field col s12 m6'>
              <input name='jawaban[]' type='text'>  <label for='jawaban' >Jawaban</label>
            </div>
          </div>

          <div class="row" id="pertanyaan3">
            <div class='input-field col s12 m5'>  <input name='pertanyaan[]' type='text' value="Nomor kontak" readonly="true"> <label for='pertanyaan' >Pertanyaan</label> </div>
            <div class='input-field col s12 m6'>
              <input name='jawaban[]' type='text'>  <label for='jawaban' >Jawaban</label>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Simpan <i class="mdi-content-send right"></i> </button>
          <a href="#" class="btn red waves-effect waves-light right modal-action modal-close">Batal <i class="mdi-content-clear right"></i></a>
          <a class="btn blue waves-effect waves-light right" id="tambah">Tambah Pertanyaan<i class="mdi-editor-border-color right"></i></a>
        </div>
      </form>
    </div>

<!-- /modal form -->

<script type="text/javascript">
  setKota();
  setKecamatan();
  setKelurahan();

  $("#provinsi").change(function(event){
    getKota(this.value);
  });

  $("#kotakabupaten").change(function(event){
    getKecamatan(this.value);
  });  

  $("#kecamatan").change(function(event){
    getKelurahan(this.value);
  });

  function setKota(){
    provinsi = $("#provinsi").val();
    kotakabupaten = $("#kotakabupatenx").val();
    if(provinsi != ""){
      getKota(provinsi, kotakabupaten);
    }
  }  

  function setKecamatan(){
    kota = $("#kotakabupatenx").val();
    kecamatan = $("#kecamatanx").val();
    if(kota != ""){
      getKecamatan(kota, kecamatan);
    }
  }  

  function setKelurahan(){
    kecamatan = $("#kecamatanx").val();
    kelurahan = $("#kelurahanx").val();
    if(kecamatan != ""){
      getKelurahan(kecamatan, kelurahan);
    }
  }

  function getKota(idProvinsi, kotakabupaten=""){
    $.post('<?php echo base_url();?>kota/listKota', {id:idProvinsi},
    function(data, response) {
      try{
          var hasil = jQuery.parseJSON(data);
          var options =[];

          $.each(hasil, function(key, value) {
              options.push(
                {v:value, k: key}
              );
          });

          options.sort(function(a,b){
             if(a.v > b.v){ return 1}
              if(a.v < b.v){ return -1}
                return 0;
          });

          $("#kotakabupaten").empty();
          var $newOptawal = $("<option>").attr("value","").text("Pilih Kabupaten / Kota");
          $("#kotakabupaten").append($newOptawal);
          $.each(options, function(jk, itemk){
            
            i = itemk.k;
            item = itemk.v

            if (i == kotakabupaten) {  selected = true; } else {  selected = false; }
            var $newOpt = $("<option>").attr("value",i).text(item).prop('selected', selected);
            $("#kotakabupaten").append($newOpt);
            
          });

          $("#kotakabupaten").material_select();
      }
      catch(ex){
        console.log("error "+ex);
        $("#kotakabupaten").empty();
        $("#kotakabupaten").append("<option value=''>Pilih Kota / Kabupaten</option>");
      }

    });
  }  

  function getKecamatan(idKota, kecamatan=""){
    $.post('<?php echo base_url();?>kecamatan/listKecamatan', {id:idKota},
    function(data, response) {
      try{
          var hasil = jQuery.parseJSON(data);
          var options =[];

          $.each(hasil, function(key, value) {
              options.push(
                {v:value, k: key}
              );
          });

          options.sort(function(a,b){
             if(a.v > b.v){ return 1}
              if(a.v < b.v){ return -1}
                return 0;
          });

          $("#kecamatan").empty();          
          var $newOptawal = $("<option>").attr("value","").text("Pilih Kecamatan");
          $("#kecamatan").append($newOptawal);
          $.each(options, function(jk, itemk){
            
            i = itemk.k;
            item = itemk.v

            if (i == kecamatan) {  selected = true; } else {  selected = false; }
            var $newOpt = $("<option>").attr("value",i).text(item).prop('selected', selected);
            $("#kecamatan").append($newOpt);
            
          });

          $("#kecamatan").material_select();    
      }
      catch(ex){
        console.log("error "+ex);
        $("#kecamatan").empty();
        $("#kecamatan").append("<option value=''>Pilih Kecamatan</option>");
      }
      
    });
  }

  function getKelurahan(idKecamatan, kelurahan=""){
    $.post('<?php echo base_url();?>kelurahan/listKelurahan', {id:idKecamatan},
    function(data, response) {
      try{
          var hasil = jQuery.parseJSON(data);
          var options =[];

          $.each(hasil, function(key, value) {
              options.push(
                {v:value, k: key}
              );
          });

          options.sort(function(a,b){
             if(a.v > b.v){ return 1}
              if(a.v < b.v){ return -1}
                return 0;
          });

          $("#kelurahan").empty();

          var $newOptawal = $("<option>").attr("value","").text("Pilih Kelurahan");
          $("#kelurahan").append($newOptawal);
          $.each(options, function(jk, itemk){
            
            i = itemk.k;
            item = itemk.v

            if (i == kelurahan) {  selected = true; } else {  selected = false; }
            var $newOpt = $("<option>").attr("value",i).text(item).prop('selected', selected);
            $("#kelurahan").append($newOpt);
            
          });
          $("#kelurahan").material_select();    
      }
      catch(ex){
        console.log("error "+ex);
        $("#kelurahan").empty();
        $("#kelurahan").append("<option value=''>Pilih Kelurahan</option>");
      }
      
    });
  }
  var a=5;
  window.setTimeout(function() {
      $("#card-alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
      });
  }, 10000);

  $(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});

    $('.datepicker').pickadate({
          format: 'yyyy-mm-dd',
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 20 // Creates a dropdown of 15 years to control year
        });
  });

  function edit(id) {
    var nik = $("#nik"+id).text();
    var nama = $("#nama"+id).text();
    var tempatLahir = $("#tempatLahir"+id).text();
    var tglLahir = $("#tglLahir"+id).text();
    var gender = $("#gender"+id).text();

    $("#id").val(id);
    $("#id2").val(id);
    $("#nik").val(nik);
    $("#lnik").addClass("active"); 

    $("#nama").val(nama); 
    $("#lnama").addClass("active");

    $("#tempatLahir").val(tempatLahir); 
    $("#ltempatLahir").addClass("active");

    // $("#tanggalLahir").val(tglLahir);
    // $("#ltanggalLahir").addClass("active");

    // if (gender == "P") {
    //   $("#gender").prop('checked', true);
    // } 
  }

  $("#tambah").click(function(){
    var div = $(document.createElement('div')).attr("id",'pertanyaan'+a).attr("class","row");

    var pertanyaan = "<div class='input-field col s12 m5'>  <input name='pertanyaan[]' type='text'> <label for='pertanyaan' >Pertanyaan</label> </div>";
    var jawaban = "<div class='input-field col s12 m6'> <input name='jawaban[]' type='text'>  <label for='jawaban' >Jawaban</label> </div>";

    var tombol = "<a class='btn-floating waves-effect waves-light tooltipped red' data-tooltip='Hapus pertanyaan' onclick='hapus("+a+")' style='margin-top:15px'><i class='mdi-action-delete'></i></a>";      

    div.after().html(pertanyaan + jawaban + tombol);
    div.appendTo('#konten'); a++;
  }); 

  function hapus(id){
    $("#pertanyaan"+id).remove();
  } 

</script>