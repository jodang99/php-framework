<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php if (isset($title)): echo $this->escape($title).'-';endif; ?>Mini Blog</title>
		<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
	</head>
	<body>
		<div id="header">
		<h1><a herf="<?php echo $base_url; ?>/">Mini Blog</a>"</h1>
		</div>
		
		<div id="nav">
			<p>
				<?php if ($session->isAuthenticated()): ?>
				<a herf="<?php echo $base_url; ?>/">HOME</a>
				<a herf="<?php echo $base_url; ?>/account">ACCOUNT</a>
				<?php else: ?>
				<a herf="<?php echo $base_url ;?>/account/signin">LOG IN</a>
				<a herf="<?php echo $base_url ;?>/account/signup">REGISTE</a>
				<?php endif; ?>
			</p>
		</div>
	
		<div id="main">
		<?php echo $_content; ?>
		</div>
		
	</body>
</html>