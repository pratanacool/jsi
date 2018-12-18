<?php if($this->session->flashdata('success')){ ?>
  <div id="card-alert" class="card green lighten-5">
    <div class="card-content green-text">
      <p><?php echo $this->session->flashdata('success'); ?></p>
    </div>
    <button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>

<?php } else if($this->session->flashdata('failed')){  ?>
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

        <form class="col s12" action="<?php echo base_url();?>pemilih/simpanPemilih" method="post">
        <!-- <div class="col s12"> -->
          <h4 class="header2">form</h4>
          <div class="row">

            <div class="input-field col s2">
              <?php
                echo form_dropdown('provinsi', $listProvinsi, '', 'id="provinsi"');
              ?>
              <label for="icon_prefix">Provinsi</label>
            </div>          

            <div class="input-field col s3">
              <select name="kota" id="kotakabupaten">
                <option value="">Pilih Kota / Kabupaten</option>
              </select>
              <label for="icon_prefix">Kabupaten / Kota</label>
            </div>

            <div class="input-field col s3">
              <select name="kecamatan" id="kecamatan">
                <option value="">Pilih Kecamatan</option>
              </select>
              <label for="icon_prefix">Kecamatan</label>
            </div>

            <div class="input-field col s3">
              <select name="kelurahan" id="kelurahan">
                <option value="">Pilih Kelurahan</option>
              </select>
              <label for="icon_prefix">Kelurahan</label>
            </div>

            <div class="input-field col s2">
              <input placeholder="NIK" type="text" name="nik">
              <label for="NIK">NIK</label>
            </div>                

            <div class="input-field col s5">
              <input placeholder="Nama" type="text" name="nama">
              <label for="icon_email">Nama</label>
            </div>        

            <div class="input-field col s3">
              <input placeholder="Tempat Lahir" type="text" name="tempatLahir">
              <label for="icon_email">Tempat Lahir</label>
            </div>        

            <div class="input-field col s2">
              <input type="date" class="datepicker" name="tanggalLahir" placeholder="Tanggal Lahir">
              <label for="dob">Tanggal Lahir</label>
            </div>

          </div>

          <div class="row">
            
            <div class="input-field col s5">
              <div class="input-field col s12 m3">
                <button class="btn cyan waves-effect waves-light right-align" type="submit" name="action" value="search"> Submit </button>
              </div>
            </div>    

          </div>
        <!-- </div> -->
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

  $("#provinsi").change(function(event){
    getKota(this.value);
  });

  $("#kotakabupaten").change(function(event){
    getKecamatan(this.value);
  });  

  $("#kecamatan").change(function(event){
    getKelurahan(this.value);
  });

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

</script>