<div class="container">
	<h1>Overview</h1>

	<div class="row">
		<div class="span1 offset11">
			<a href="<?php echo current_url(); ?>" rel="tooltip" title="Refresh"><i class="icon-refresh"></i></a>
		</div>
	</div>


	<?php $rowcount = 0;?>
	
	<?php foreach ($groups as $group) { ?>
	
	<?php if ($rowcount == 0) {?>
	<div class="row">
	<?php } ?>
	
		<div class="span2">
	
			<table class="table table-hover">
				<thead>
					<tr>
						<th><?php echo $group['name']; ?></th>
					</tr>
				</thead>
				
				<tbody>
				
					<?php if(!$servers[$group['name']]) {?>
					<tr>
						<td></td>
					</tr>
					<?php }?>
					
					<?php foreach ($servers[$group['name']] as $server) { ?>

					<?php if ($server['status'] == "ok") {?>
					<tr>
						<td><span class="badge badge-success"><i class="icon-ok icon-white"></i></span>
					<?php } elseif ($server['status'] == "warning") { ?>
					<tr>
						<td><span class="badge badge-warning"><i class="icon-random icon-white"></i></span>
					<?php } elseif ($server['status'] == "error") { ?>
					<tr>
						<td><span class="badge badge-important"><i class="icon-remove icon-white"></i></span>
					<?php } else { ?>
					<tr>
						<td><span class="badge"><i class="icon-question-sign icon-white"></i></span>
					<?php } ?>
						<a href="#" rel="tooltip" title="<?php echo $server['timestamp'].' '.$server['hostname']; ?>"><?php echo $server['name']; ?></a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
		
	<?php if ($rowcount == 5) {?>
	</div>
	<?php
		$rowcount = 0;
	} else {
		$rowcount++;
	} ?>

	<?php } // foreach groups?>
	<?php if ($rowcount != 6) {?>
	</div>
	<?php } ?>

</div>
