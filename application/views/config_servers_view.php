<div class="container">
	<h1>Overview</h1>

	<div class="row">

		<div class="span8 offset2">
			<div class="pagination">
				<ul>
					<?php if ($pagination['current'] != '1') {?>
					<li><a href="<?php echo base_url();?>config/servers/<?php echo $pagination['current'] - 1;?>">Prev</a></li>
					<?php } else { ?>
					<li class="disabled"><a href="#">Prev</a></li>
					<?php } ?>
					
					<?php for ($i = 1; $i <= $pagination['pages']; $i++) { ?>
						<?php if ($pagination['current'] == $i) { ?>
					<li class='active'><a href="#"><?php echo $i;?></a></li>
						<?php } else { ?>
					<li><a href="<?php echo base_url();?>config/servers/<?php echo $i;?>"><?php echo $i;?></a></li>
						<?php } ?>
					<?php } ?>
					
					<?php if ($pagination['current'] != $pagination['pages']) {?>
					<li><a href="<?php echo base_url();?>config/servers/<?php echo $pagination['current'] + 1;?>">Next</a></li>
					<?php } else { ?>
					<li class="disabled"><a href="#">Next</a></li>
					<?php } ?>
					
				</ul>
			</div>
	
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Active</th>
						<th>Hostname</th>
						<th>Group</th>
						<th>Name</th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach ($servers as $server) { ?>

					<tr>
						<td>
							<?php if ($server['active'] == 1) {?>
							<a href="<?php echo base_url();?>config/disable/<?php echo $server['id']; ?>"><span class="badge badge-success"><i class="icon-ok icon-white"></i></a>
							<?php } else { ?>
							<a href="<?php echo base_url();?>config/enable/<?php echo $server['id']; ?>"><span class="badge badge-important"><i class="icon-remove icon-white"></i></a>
							<?php } ?>
						</td>
						<td><?php echo $server['hostname']; ?></td>
						<td><?php echo $server['groups']; ?></td>
						<td><?php echo $server['name']; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
		<div class="span2"></div>
		
	</div>
</div>
