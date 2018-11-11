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
            

            <div class="input-field col s3">
              <?php
                echo form_dropdown('pilihan', $listPilihan, $pilihan);
              ?>
              <label for="icon_prefix">Kategori</label>
            </div>             


            <div class="input-field col s2">
              <?php
                echo form_dropdown('pemilih', $listTipePemilih, $tipePemilih);
              ?>
              <label for="icon_prefix">Tipe Pemilih</label>
            </div>  

            <div class="input-field col s2">
              <?php
                echo form_dropdown('kontak', $listKontak, $kontak);
              ?>
              <label for="icon_prefix">Kontak Pemilih</label>
            </div>  


            <div class="input-field col s1  offset-s4">
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
        <code>Total Data Ditemukan: <?php echo $totalData;?> Orang</code> 
        <hr>
        <code>Pemilih Yang Dikunjungi : <?php echo $totalKonsolidasi;?> Orang</code>
        <hr>        
        <code>Pemilih Kategori A : <?php echo $totalA;?> Orang</code><br>
        <code>Pemilih Kategori B : <?php echo $totalB;?> Orang</code><br>
        <code>Pemilih Kategori C : <?php echo $totalC;?> Orang</code><br>
        <code>Pemilih Kategori D : <?php echo $totalD;?> Orang</code><br>
        <code>Pemilih Kategori E : <?php echo $totalE;?> Orang</code>
        <hr>        
        <code>Potensi Pemilih: <?php echo $totalA + $totalB + $totalC;?> Orang</code>
        <hr>        
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
                <th>Pilihan pilleg</th>
                <th>Jumlah pemilih</th>
                <th>Nomor Kontak</th>
                <th>Tipe Pemilih</th>
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
                  echo "<td style='text-align:center'>".$row['pilihan']."</td>";
                  echo "<td style='text-align:right'>".$row['jumPemilih']."</td>";
                  echo "<td style='text-align:right'>".$row['kontak']."</td>";
                  echo "<td style='text-align:right'>".$row['tipe_pemilih']."</td>";
                  echo "<td style='text-align:center'>";
                    echo "<a class='btn-floating waves-effect waves-light tooltipped modal-trigger blue' data-tooltip='Interview pemilih' onclick='view($id)' href='#modalInterview'><i class='mdi-action-assignment'></i></a>";

                    echo "<a class='btn-floating waves-effect waves-light tooltipped modal-trigger orange' data-tooltip='Interview pemilih' onclick='edit($id)' href='#modalEditInterview'><i class='mdi-action-assignment-late'></i></a>";
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

<!-- modal form -->

    <div id="modalEditInterview" class="modal modal-fixed-footer">
      <form action="<?php echo base_url();?>pemilih/editInterview" method="POST" id="formKu" enctype="multipart/form-data">
        <div class="modal-content" id="editKonten">
          

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

  var pilihan ={
                  "A":"A. Partai saya, Caleg saya",
                  "B":"B. Partai saya, Belum ada caleg",
                  "C":"C. Tidak tahu / Tidak jawab",
                  "D":"D. Partai saya, Caleg lain",
                  "E":"E. Partai lain, Caleg lain"
                };
  
  var tipePemilih={
                    "1":"Relawan",
                    "2":"Kerabat / Keluarga",
                    "3":"Pemilih Biasa"
                  };

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

  var a=0;
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

  function view(id) {
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
            jawabanPemilih = item.jawaban;
            interview +="<div class='row'>";
            interview +="<div class='input-field col m1'><code>"+ j +"</code></div>";
            interview +="<div class='input-field col m5'><strong>"+item.pertanyaan+"</strong></div>";

            if(j == 1){
             jawabanPemilih = pilihan[item.jawaban]; 
            }

            else if(j == 2){
              jawabanPemilih = tipePemilih[item.jawaban]; 
            }

            interview +="<div class='input-field col m6'>"+jawabanPemilih+"</div>";
            interview +="</div>";
          });
          $("#konten").append(interview);
      }
      catch(ex){
        console.log("error "+ex);
      }
    });
  }  

  function edit(id) {
    $("#editKonten").empty();
    var nik = $("#nik"+id).text();
    var nama = $("#nama"+id).text();
    var idCaleg = "";
    var idPemilih = "";
    var idMaster = "";
    var select = "";
    $.post('<?php echo base_url();?>pemilih/getInterview', {idPemilih:id},
      function(data, response) {
      try{
          var interview = "<h4 class='header2'>Hasil Konsolidasi "+nama+" ("+nik+")</h4>";
          $("#konten").empty();
          var hasil = jQuery.parseJSON(data);
          j=0;
          $.each(hasil, function(i, item){
            idCaleg = item.caleg_id;
            idPemilih = item.pemilih_id;
            idMaster = item.master_id;

            j++;
            jawabanPemilih = item.jawaban;
            interview +="<div class='row' id='pertanyaan"+j+"'>";
            interview +="<div class='input-field col m5'><strong><input name='pertanyaan[]' type='text' value='"+item.pertanyaan+"'> </strong></div>";
            
            if(j==1){

            interview += "<div class='input-field col m6'> <select name='jawaban[]' id='pilihan' >";
              $.each(pilihan, function(i, p) {
                  if(i == item.jawaban){ opt = "selected='selected'"}else{opt = false}
                  interview += "<option value='"+i+"' "+opt+" >"+p+"</option>";
              });
            interview += "</select> </div>";

            }

            else if(j == 2){
              interview += "<div class='input-field col m6'> <select name='jawaban[]' id='pemilih' >";
                $.each(tipePemilih, function(i2, p2) {
                    if(i2 == item.jawaban){ opt2 = "selected='selected'"}else{opt2 = false}
                    interview += "<option value='"+i2+"' "+opt2+" >"+p2+"</option>";
                });
              interview += "</select> </div>";
            }

            else{
              interview +="<div class='input-field col m6'><input name='jawaban[]' type='text' value='"+item.jawaban+"'></div>";  
            }

            interview += "<a class='btn-floating waves-effect waves-light tooltipped red' data-tooltip='Hapus pertanyaan' onclick='hapus("+j+")' style='margin-top:15px'><i class='mdi-action-delete'></i></a>"; 
            interview +="</div>";

          });

          interview +="<input name='idCaleg' type='hidden' value='"+idCaleg+"'>";
          interview +="<input name='idPemilih' type='hidden' value='"+idPemilih+"'>";
          interview +="<input name='idMaster' type='hidden' value='"+idMaster+"'>";
          a=j+1;

          $("#editKonten").append(interview);
          $("#pilihan").material_select();  
          $("#pemilih").material_select();  
      }
      catch(ex){
        console.log("error "+ex);
      }
    });
  }

  $("#tambah").click(function(){
    var div = $(document.createElement('div')).attr("id",'pertanyaan'+a).attr("class","row");

    var pertanyaan = "<div class='input-field col s12 m5'>  <input name='pertanyaan[]' type='text'> <label for='pertanyaan' >Pertanyaan</label> </div>";
    var jawaban = "<div class='input-field col s12 m6'> <input name='jawaban[]' type='text'>  <label for='jawaban' >Jawaban</label> </div>";

    var tombol = "<a class='btn-floating waves-effect waves-light tooltipped red' data-tooltip='Hapus pertanyaan' onclick='hapus("+a+")' style='margin-top:15px'><i class='mdi-action-delete'></i></a>";      

    div.after().html(pertanyaan + jawaban + tombol);
    div.appendTo('#editKonten'); a++;
  }); 

  function hapus(id){
    $("#pertanyaan"+id).remove();
  } 

</script>