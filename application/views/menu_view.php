<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">

            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href="<?php echo base_url();?>">MD</a>

            <div class="nav-collapse collapse">
                <ul class="nav">

                    <?php if ($page == "home"){ ?>
                    <li class="active">
                    <?php } else { ?>
                    <li>
                    <?php } ?>
                    <a href="<?php echo base_url();?>">Home</a></li>
                      
                    <?php if($this->session->userdata('validated')){?>

                    <?php if ($page == "view"){ ?>
                    <li class="active">
                    <?php } else { ?>
                    <li>
                    <?php } ?>
                    <a href="<?php echo base_url();?>view/">View</a></li>
                    
                    <?php if ($page == "servers"){ ?>
                    <li class="dropdown active">
                    <?php } else { ?>
                    <li class="dropdown">
                    <?php } ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Servers</a>
						<ul class="dropdown-menu" role="menu">
							<li><a tabindex="-1" href="<?php echo base_url();?>servers/overview/all">All servers</a></li>
							<li><a tabindex="-1" href="<?php echo base_url();?>servers/overview/problem">Problem</a></li>
							<li class="divider"></li>
							<li><a tabindex="-1" href="<?php echo base_url();?>servers/overview/ok">Ok</a></li>
							<li><a tabindex="-1" href="<?php echo base_url();?>servers/overview/warning">Warning</a></li>
							<li><a tabindex="-1" href="<?php echo base_url();?>servers/overview/error">Error</a></li>
							<li><a tabindex="-1" href="<?php echo base_url();?>servers/overview/na">Not Available</a></li>
						</ul>
					</li>

                    <?php if ($page == "logbook"){ ?>
                    <li class="active">
                    <?php } else { ?>
                    <li>
                    <?php } ?>
                    <a href="<?php echo base_url();?>logbook/view/">Logbook</a></li>
					
                    <?php if ($page == "config"){ ?>
                    <li class="dropdown active">
                    <?php } else { ?>
                    <li class="dropdown">
                    <?php } ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Config</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a tabindex="-1" href="<?php echo base_url();?>config/options">Options</a></li>
                            <li><a tabindex="-1" href="<?php echo base_url();?>config/servers">Servers</a></li>
                            <li><a tabindex="-1" href="<?php echo base_url();?>config/users">Users</a></li>
                        </ul>
                    </li>

                    <?php } ?>

                    <?php if(! $this->session->userdata('validated')){?>
                      
					<?php if ($page == "login"){ ?>
                    <li class="active">
                    <?php } else { ?>
                    <li>
                    <?php } ?>
                    <a href="<?php echo base_url();?>login/">Login</a></li>
                    
                    <?php } else { ?>
                      <li><a href="<?php echo base_url();?>logout/">Logout</a></li>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </div>
</div>
