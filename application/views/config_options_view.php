<div class="container">
	<h1>Options</h1>

	<div class="row">
		<div class="span12">
    		<ul class="nav nav-tabs">
        		<?php if ($tab == "common"){ ?>
        		<li class="active">
        		<?php } else { ?>
        		<li>
        		<?php } ?>
    				<a href="<?php echo base_url();?>config/options/common/">Common</a>
    			</li>

        		<?php if ($tab == "proxy"){ ?>
        		<li class="active">
        		<?php } else { ?>
        		<li>
        		<?php } ?>
    				<a href="<?php echo base_url();?>config/options/proxy/">Proxy</a>
    			</li>
				
        		<?php if ($tab == "api"){ ?>
        		<li class="active">
        		<?php } else { ?>
        		<li>
        		<?php } ?>
    				<a href="<?php echo base_url();?>config/options/api/">Api</a>
    			</li>
    		</ul>
    	</div>
    </div>

    <?php if ($tab == "common"){ ?>

   	<?php } elseif ($tab == "proxy") { ?>

	<h3>Default proxy server settings.</h3>

	<?php $attributes = array('class' => 'form-horizontal');
	echo form_open('config/save/proxy/', $attributes); ?>
   		<div class="control-group">
   			<label class="control-label" for="proxyhost">Proxy servername:</label>
   			<div class="controls">
   				<input type="text" id="proxyhost" name="proxyhost" placeholder="Proxy servername" value="<?php echo $setting['proxyhost']; ?>">
   				<input type="text" id="proxyhost" name="proxyport" class="input-small" placeholder="8080" value="<?php echo $setting['proxyport']; ?>">
   			</div>
   		</div>

   		<div class="control-group">
   			<label class="control-label" for="http">Proxy type:</label>
   			<div class="controls">
   				<?php if ($setting['proxytype'] == "http") {$checked = 'checked';} else {$checked=''; } ?>
   				<label class="radio"><input type="radio" name="proxytype" value="http" <?php echo $checked; ?>>HTTP</label>
   				<?php if ($setting['proxytype'] == "socks5") {$checked = 'checked';} else {$checked=''; } ?>
   				<label class="radio"><input type="radio" name="proxytype" value="socks5" <?php echo $checked; ?>>Socks5</label>
   			</div>
   		</div>

   		<div class="control-group">
   			<label class="control-label" for="proxyauth">Proxy authentication:</label>
   			<div class="controls">
   				<input type="text" id="proxyauth" name="proxyuser" class="input-small" placeholder="Username"  value="<?php echo $setting['proxyuser']; ?>">
    			<input type="password" id="proxyauth" name="proxypassword" class="input-small" placeholder="Password" value="<?php echo $setting['proxypassword']; ?>">
   			</div>
   		</div>

   		<div class="control-group">
   			<div class="controls">
   				<button type="submit" class="btn">Submit</button>
   			</div>
   		</div>

    </form>

	<?php } elseif ($tab == "api") { ?>
	
    <?php } ?>

</div>
