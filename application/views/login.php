
<?php if($this->session->flashdata('failed')){  ?>
  <div id="card-alert" class="card red lighten-5">
    <div class="card-content red-text">
      <p><?php echo $this->session->flashdata('failed'); ?></p>
    </div>
    <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
<?php } ?>

  <div id="login-page" class="row">
    <div class="col s12 m3 offset-m4 center-align card-panel" style="padding: 30px;" >
      <form class="login-form" action="<?php echo base_url();?>login/proses" method="post">

        <div class="row">
          <div class="input-field col s12 center">
            <p class="center login-form-text">JSI Konsultan</p>
          </div>
        </div>

        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input name="username" type="text">
            <label for="username" class="center-align">Username</label>
          </div>
        </div>

        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input name="password" type="password">
            <label for="password">Password</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <button class="btn cyan waves-effect waves-light right-align" type="submit" name="action" value="search"><i class="mdi-action-search"></i> Login</button>
          </div>
        </div>

      </form>
    </div>
  </div>
