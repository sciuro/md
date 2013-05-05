<div class="container">
	<h1>Server information</h1>

	<div class="row">
		<div class="span12">
    		<ul class="nav nav-tabs">
        		<?php if ($tab == "overview"){ ?>
        		<li class="active">
        		<?php } else { ?>
        		<li>
        		<?php } ?>
    				<a href="<?php echo base_url();?>servers/show/<?php echo $server['id'];?>">Overview</a>
    			</li>

        		<?php if ($tab == "statistics"){ ?>
        		<li class="active">
        		<?php } else { ?>
        		<li>
        		<?php } ?>
    				<a href="<?php echo base_url();?>servers/show/<?php echo $server['id'];?>/statistics/">Statistics</a>
    			</li>
				
        		<?php if ($tab == "logbook"){ ?>
        		<li class="active">
        		<?php } else { ?>
        		<li>
        		<?php } ?>
    				<a href="<?php echo base_url();?>servers/show/<?php echo $server['id'];?>/logbook/">Logbook</a>
    			</li>
    		</ul>
    	</div>
    </div>

    <?php if ($tab == "overview"){ ?>
	<div class="row">
		<div class="span5 offset1">
			<h3>Information</h3>
			<table>
				<tbody>
					<tr><td>Group:</td><td><?php echo $server['groups'];?></td></tr>
					<tr><td>Function:</td><td><?php echo $server['name'];?></td></tr>
					<tr><td>Hostname:</td><td><?php echo $server['hostname'];?></td></tr>
					<tr><td>OS:</td><td><?php echo $serverinfo['os'];?></td></tr>
					<tr><td>Kernel:</td><td><?php echo $serverinfo['kernel'];?></td></tr>
					<tr><td>CPU Type:</td><td><?php echo $serverinfo['cputype'];?></td></tr>
					<tr><td>CPU's:</td><td><?php echo $serverinfo['cpucount'];?></td></tr>
					<tr><td>Memory:</td><td><?php echo $serverinfo['memory'];?> GB</td></tr>
					<tr><td>Swapspace:</td><td><?php echo $serverinfo['swap'];?> GB</td></tr>
					<tr><td>Last update:</td><td><?php echo $serverinfo['timestamp'];?></td></tr>
					<tr><td>Description:</td><td><?php echo $server['desc'];?></td></tr>
				</tbody>
			</table>
    	</div>
		<div class="span6">
			<h3>Services</h3>
			<?php foreach ($services as $service) { ?>
				<?php $tooltipmsg = $logbook[$service['id']]['timestamp']."      ".$logbook[$service['id']]['message'];?>
				<p>
				<?php if ($service['status'] == "ok") {?>
					<span class="badge badge-success" rel="tooltip" title="<?php echo $tooltipmsg;?>"><i class="icon-ok icon-white"></i></span>
				<?php } elseif ($service['status'] == "warning") { ?>
					<span class="badge badge-warning" rel="tooltip" title="<?php echo $tooltipmsg;?>"><i class="icon-random icon-white"></i></span>
				<?php } elseif ($service['status'] == "error") { ?>
					<span class="badge badge-important" rel="tooltip" title="<?php echo $tooltipmsg;?>"><i class="icon-remove icon-white"></i></span>
				<?php } else { ?>
					<span class="badge" rel="tooltip" title="<?php echo $tooltipmsg;?>"><i class="icon-question-sign icon-white"></i></span>
				<?php } ?>
					<?php echo $service['name'];?></p>
			<?php } ?>
    	</div>
	</div>

   	<?php } elseif ($tab == "statistics") { ?>

	<div id="graph_cpu" style="width:600px;height:300px;"></div>
	<script id="source">
		$(function () {
			var user = { label: "user", data: [
			<?php foreach ($stats_cpu as $stat) {
				echo "[".$stat['time'].", ".$stat['user']."], ";
			} ?>
			]};
			
			var system = { label: "system", data: [
			<?php foreach ($stats_cpu as $stat) {
				echo "[".$stat['time'].", ".$stat['system']."], ";
			} ?>
			]};
			
			var wait = { label: "wait", data: [
			<?php foreach ($stats_cpu as $stat) {
				echo "[".$stat['time'].", ".$stat['wait']."], ";
			} ?>
			]};

			$.plot($("#graph_cpu"), [user, system, wait], { xaxis: { mode: "time" } });
		});
	</script>

	<div id="graph_load" style="width:600px;height:300px;"></div>
	<script id="source">
		$(function () {
			var avg01 = { label: "1 minute", data: [
			<?php foreach ($stats_load as $stat) {
				echo "[".$stat['time'].", ".$stat['avg01']."], ";
			} ?>
			]};
			
			var avg05 = { label: "5 minutes", data: [
			<?php foreach ($stats_load as $stat) {
				echo "[".$stat['time'].", ".$stat['avg05']."], ";
			} ?>
			]};
			
			var avg15 = { label: "15 minutes", data: [
			<?php foreach ($stats_load as $stat) {
				echo "[".$stat['time'].", ".$stat['avg15']."], ";
			} ?>
			]};

			$.plot($("#graph_load"), [avg01, avg05, avg15], { xaxis: { mode: "time" } });
		});
	</script>	

	<div id="graph_memory" style="width:600px;height:300px;"></div>
	<script id="source">
		$(function () {
			var memory = { label: "memory", data: [
			<?php foreach ($stats_memory as $stat) {
				echo "[".$stat['time'].", ".$stat['used']."], ";
			} ?>
			]};
			
			var swap = { label: "swap", data: [
			<?php foreach ($stats_memory as $stat) {
				echo "[".$stat['time'].", ".$stat['swap']."], ";
			} ?>
			]};

			$.plot($("#graph_memory"), [memory, swap], { xaxis: { mode: "time" } });
		});
	</script>
	
	<?php } elseif ($tab == "logbook") { ?>
	
    <?php } ?>

</div>
