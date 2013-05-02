<div class="container">
	<h1>Logbook</h1>

	<div class="row">
		<div class="span1 offset11">
			<a href="<?php echo current_url(); ?>" rel="tooltip" title="Refresh"><i class="icon-refresh"></i></a>
		</div>
	</div>
	
	<div class="row">

		<div class="span10 offset1">
			<div class="pagination">
				<ul>
					<?php if ($pagination['current'] != '1') {?>
					<li><a href="<?php echo base_url();?>logbook/view/<?php echo $pagination['current'] - 1;?>">Prev</a></li>
					<?php } else { ?>
					<li class="disabled"><a href="#">Prev</a></li>
					<?php } ?>
					
					<?php for ($i = 1; $i <= $pagination['pages']; $i++) { ?>
						<?php if ($pagination['current'] == $i) { ?>
					<li class='active'><a href="#"><?php echo $i;?></a></li>
						<?php } else { ?>
					<li><a href="<?php echo base_url();?>logbook/view/<?php echo $i;?>"><?php echo $i;?></a></li>
						<?php } ?>
					<?php } ?>
					
					<?php if ($pagination['current'] != $pagination['pages']) {?>
					<li><a href="<?php echo base_url();?>logbook/view/<?php echo $pagination['current'] + 1;?>">Next</a></li>
					<?php } else { ?>
					<li class="disabled"><a href="#">Next</a></li>
					<?php } ?>
					
				</ul>
			</div>
	
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Time</th>
						<th>Group</th>
						<th>Server</th>
						<th>Service</th>
						<th>Status</th>
						<th>Message</th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach ($logbook as $logitem) { ?>

					<tr>
						<td><?php echo $logitem['timestamp']; ?></td>
						<td><?php echo $logitem['groups']; ?></td>
						<td><?php echo $logitem['servername']; ?></td>
						<td><?php echo $logitem['servicename']; ?></td>
						<td class='<?php if ($logitem['status'] == 'ok') {echo 'text-success';}
											elseif ($logitem['status'] == 'warning') {echo 'text-warning';}
											elseif ($logitem['status'] == 'error') {echo 'text-error';}
											elseif ($logitem['status'] == 'na') {echo 'muted';}
											?>'><?php echo $logitem['status']; ?></td>
						<td><?php echo $logitem['message']; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
		<div class="span2"></div>
		
	</div>
</div>
