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
            </div>

            <div class="input-field col s3">
              <input type="hidden" id="kecamatanx" value="<?php echo $kecamatan; ?>">
              <select name="kecamatan" id="kecamatan">
                <option value="">Pilih Kecamatan</option>
              </select>
            </div>

            <div class="input-field col s3">
              <input type="hidden" id="kelurahanx" value="<?php echo $kelurahan; ?>">
              <select name="kelurahan" id="kelurahan">
                <option value="">Pilih Kelurahan</option>
              </select>
            </div>
            
            <div class="input-field col s3">
              <input placeholder="Nama / NIk" type="text" name="search" value="<?php echo $search;?>">
              <label for="icon_email">Nama / Nik</label>
            </div>
            
            <div class="input-field col s2 offset-s7">
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right-align" type="submit" name="action"><i class="mdi-action-search"></i> Cari</button>
              </div>
            </div>

          </div>
        </form>
      
      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="col s12 m12 l12">
    <div class="card-panel">
      <div class="row">          

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
                    echo "<a class='btn-floating waves-effect waves-light tooltipped modal-trigger orange' data-tooltip='Edit data pemilih' href='#modalEdit' onclick='edit($row->id)'><i class='mdi-editor-mode-edit' alt='edit'></i></a> | "; 
                    echo "<a class='btn-floating waves-effect waves-light tooltipped modal-trigger blue' data-tooltip='Interview pemilih' onclick='edit($row->id)' href='#modalInterview'><i class='mdi-action-assignment'></i></a>";
                  echo "</td>";
                echo "</tr>";
              }
            ?>        
            </tbody>
          </table>

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


    <div id="modalInterview" class="modal modal-fixed-footer">
      <form action="<?php echo base_url();?>pemilih/simpanInterview" method="POST" id="formKu" enctype="multipart/form-data">
        <div class="modal-content" id="konten">

          <h4 class="header2">Form Kuesioner</h4>
          <input id="id2" name="id" type="hidden">
          <input name="idCaleg" type="hidden" value="1">
          
          <div class="row" id="pertanyaan1">
            <div class='input-field col s12 m5'>  <input name='pertanyaan[]' type='text' value="Pilihan anda di pilkada"> <label for='pertanyaan' >Pertanyaan</label> </div>
            <div class='input-field col s12 m6'>
              <!-- <label>Pilihan anda</label> -->
                    <?php
                      echo form_dropdown('jawaban[]', $listPilihan,'id="pilihan"');
                    ?>
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
// setKota();
 // setKecamatan();
 // setKelurahan();

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
    getKota(provinsi, kotakabupaten);
  }  

  function setKecamatan(){
    kota = $("#kotakabupatenx").val();
    kecamatan = $("#kecamatanx").val();
    getKecamatan(kota, kecamatan);
  }  

  function setKelurahan(){
    kecamatan = $("#kecamatanx").val();
    kelurahan = $("#kelurahanx").val();
    getKelurahan(kecamatan, kelurahan);
  }


  function getKota(idProvinsi, kotakabupaten=""){
    $.post('<?php echo base_url();?>kota/listKota', {id:idProvinsi},
    function(data, response) {
      try{
          var hasil = jQuery.parseJSON(data);
          var options ='';
          $("#kotakabupaten").empty();
          $.each(hasil, function(i, item){
            if (i == kotakabupaten) {  selected = true; } else {  selected = false; }
            var $newOpt = $("<option>").attr("value",i).text(item).prop('selected', selected);
            $("#kotakabupaten").append($newOpt);
          });
      }
      catch(ex){
        console.log("error "+ex);
        $("#kotakabupaten").empty();
        $("#kotakabupaten").append("<option value=''>Pilih Kota / Kabupaten</option>");
      }

      $("#kotakabupaten").material_select();

    });
  }  

  function getKecamatan(idKota, kecamatan=""){
    $.post('.././kecamatan/listKecamatan', {id:idKota},
    function(data, response) {
      try{
          var hasil = jQuery.parseJSON(data);
          var options ='';
          $("#kecamatan").empty();
          $.each(hasil, function(i, item){
            if (i == kecamatan) {  selected = true; } else {  selected = false; }

            var $newOpt = $("<option>").attr("value",i).text(item).prop('selected', selected);
            $("#kecamatan").append($newOpt);

          });
          
      }
      catch(ex){
        console.log("error "+ex);
        $("#kecamatan").empty();
        $("#kecamatan").append("<option value=''>Pilih Kota / Kabupaten</option>");
      }
      $("#kecamatan").material_select();
    });
  }

  function getKelurahan(idKecamatan, kelurahan=""){
    console.log(idKecamatan);
    console.log(kelurahan);
    $.post('.././kelurahan/listKelurahan', {id:idKecamatan},
    function(data, response) {
      try{
          var hasil = jQuery.parseJSON(data);
          var options ='';
          $("#kelurahan").empty();
          $.each(hasil, function(i, item){
            if (i == kelurahan) {  selected = true; } else {  selected = false; }

            var $newOpt = $("<option>").attr("value",i).text(item).prop('selected', selected);
            $("#kelurahan").append($newOpt);

          });
          
      }
      catch(ex){
        console.log("error "+ex);
        $("#kelurahan").empty();
        $("#kelurahan").append("<option value=''>Pilih Kelurahan</option>");
      }
      $("#kelurahan").material_select();
    });
  }

  var a=2;
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

    $("#tanggalLahir").val(tglLahir);
    $("#ltanggalLahir").addClass("active");

    if (gender == "P") {
      $("#gender").prop('checked', true);
    } 
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