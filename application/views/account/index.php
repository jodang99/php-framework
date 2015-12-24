<?php $this->setLayoutVar('title','Account') ?>
<h2>Account</h2>
<p>
User ID : <a herf="<?php echo $base_url ?>/user/<?php echo $this->escape($user['user_name']); ?>">
<strong><?php echo $this->escape($user['user_name']); ?></strong>
</a>
</p>

<ul>
	<li>
		<a harf="<?php echo $base_url; ?>/">HOME</a>
		</li>
		<li>
		<a herf="<?php echo $base_url; ?>/account/signout">LOG OUT</a>
		</li>
</ul>

<h3>NOW following...</h3>
<?php if (count($followings) > 0): ?>
<ul>
<?php foreach ($followings as $following): ?>
<li>
<a herf="<?php echo $base_url; ?>/user/<?php echo $this->escape($following['user_name']); ?>">
<?php echo $this->escape($following['user_name']); ?>
</a>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>