

<?php echo $this->HTML->script('jquery', FALSE); ?>
<!DOCTYPE html>
<html>
<head>
	
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
	
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		echo $scripts_for_layout;

		

	?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="../cakephp-project/js/jquery-ui/jquery-ui.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


	
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Message Board</h1>
		</div>
		<div id="content">

			<div style="text-align: right">
			<?php if($logged_in):?>
				
				<?php 
					echo $current_user["user_name"]; ?> <?php echo $this->HTML->link('Logout', array('controller'=>'users', 'action' => 'logout')) ?>
			<?php else: ?>
				<?php echo $this->HTML->link('Login', array('controller'=>'users', 'action' => 'login')) ?>
			<?php endif ?>
			</div>

			

			<?php echo $this->fetch('content'); ?>
		</div>

	</div>
</body>


</html>
