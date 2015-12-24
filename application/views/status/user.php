<?php $this->setLayoutVar('title', $user['user_name']) ?>

<h2><?php echo $this->escape($user['user_name']); ?></h2>

<?php if (!is_null($following)): ?>
<?php if ($following): ?>
<p>Now following...</p>
<?php else: ?>
<form action="<?php echo $base_url; ?>/follow" method="post">
	<input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
	<input type="hidden" name="following_name" value="<?php echo $this->escape($user['user_name']); ?>" />
	<input type="submit" value="Follow" />

</form>
<?php endif; ?>
<?php endif; ?>


<div id="statuses">
	<?php foreach ($statueses as $status) : ?>
		<?php echo $this->render('status/status', array('status' => $status)); ?>
	<?php endforeach;?>
</div>