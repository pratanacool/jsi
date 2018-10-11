<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
                </div>
                <div class="col col s8 m8 l8">
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo namaCaleg;?></a>
                    <p class="user-roal"><?php echo partai;?></p>
                </div>
            </div>
        </li>

        <li class="bold"><a href="<?php echo base_url();?>" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Dashboard</a>
        </li>

        <li class="li-hover"><div class="divider"></div></li>
        <li class="bold"><a href="<?php echo base_url();?>pemilih/list" class="waves-effect waves-cyan"><i class="mdi-social-group"></i> Pemilih</a>
        <li class="bold"><a href="<?php echo base_url();?>pemilih/konsolidasi" class="waves-effect waves-cyan"><i class="mdi-action-assignment-turned-in"></i> Konsolidasi</a>

    </ul>

</aside>