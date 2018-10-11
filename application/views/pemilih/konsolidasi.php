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

        <form class="col s12" action="<?php echo base_url();?>pemilih/konsolidasi" method="post">
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
            

            <div class="input-field col s1  offset-s9">
              <?php
                echo form_dropdown('limit', $listLimit, $limit);
              ?>
              <label for="icon_prefix">Banyak Data</label>
            </div>

            <div class="input-field col s2">
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
                <th>Provinsi</th>
                <th>Kota</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>TPS</th>
                <th>Pilihan anda di pilleg</th>
                <th>Jumlah pemilih</th>
                <th>Nomor Kontak</th>
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
                  echo "<td>".$row['nama_provinsi']."</td>";
                  echo "<td>".$row['nama_kota']."</td>";
                  echo "<td>".$row['nama_kecamatan']."</td>";
                  echo "<td>".$row['nama_kelurahan']."</td>";
                  echo "<td>TPS ".$row['tps']."</td>";
                  echo "<td>".$row['pilihan']."</td>";
                  echo "<td>".$row['jumPemilih']."</td>";
                  echo "<td>".$row['kontak']."</td>";
                  echo "<td>";
                    echo "<a class='btn-floating waves-effect waves-light tooltipped modal-trigger blue' data-tooltip='Interview pemilih' onclick='edit($id)' href='#modalInterview'><i class='mdi-action-assignment'></i></a>";
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

    <div id="modalInterview" class="modal modal-fixed-footer">
        <div class="modal-content" id="konten">
          

        </div>

        <div class="modal-footer">
          <a href="#" class="btn red waves-effect waves-light right modal-action modal-close">Tutup <i class="mdi-content-clear right"></i></a>
        </div>
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
          var options ='';
          $("#kotakabupaten").empty();
          $.each(hasil, function(i, item){
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
          var options ='';
          $("#kecamatan").empty();
          $.each(hasil, function(i, item){
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
          var options ='';
          $("#kelurahan").empty();
          $.each(hasil, function(i, item){
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

  var a=3;
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
    $.post('<?php echo base_url();?>pemilih/getInterview', {idPemilih:id},
      function(data, response) {
      try{
          var interview = "<h4 class='header2'>Hasil Konsolidasi "+nama+" ("+nik+")</h4>";
          $("#konten").empty();
          var hasil = jQuery.parseJSON(data);
          j=0;
          $.each(hasil, function(i, item){
            j++;

            interview +="<div class='row'>";
            interview +="<div class='input-field col m1'><code>"+ j +"</code></div>";
            interview +="<div class='input-field col m5'><strong>"+item.pertanyaan+"</strong></div>";
            interview +="<div class='input-field col m6'>"+item.jawaban+"</div>";
            interview +="</div>";

            console.log(item)
          });
          $("#konten").append(interview);
      }
      catch(ex){
        console.log("error "+ex);
      }
    });
  }

</script>