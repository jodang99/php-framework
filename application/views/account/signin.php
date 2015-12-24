<?php $this->setLayoutVar('title','LOG IN') ?>

<h2>LOG IN</h2>
<p>
	<a herf=<?php echo $base_url; ?>/account/signup">NEW USER REGISTE</a>
	</p>
	
<form action="<?php echo $base_url; ?>/account/authenticate" method="post">
<input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>"/>

<?php if (isset($errors) && count($errors) > 0): ?>
<?php echo $this->render('errors',array('errors'=>$errors)); ?>
<?php endif; ?>

<?php echo $this->render('account/inputs', array(
		'user_name'=>$user_name, 'password'=>$password,)); ?>
		
		<p>
		<input type="submit" value="LOG IN" />
		</p>
	
</form>
