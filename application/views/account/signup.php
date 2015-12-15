<?php $this->setLayoutVar('title','어카운트등록')?>
<h2>어카운트등록</h2>

<form action="<?php echo $base_url; ?>/account/register" method="post">
	<input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
	
	<table>
		<tbody>
			<tr>
				<th>user_id</th>
				<td>
					<input type="text" name="user_name" value="" />
			</tr>
			<tr>
				<th>Password</th>
				<td>
					<input type="password" name="password" value="" />
				</td>
			</tr>
		</tbody>
	</table>
	
	<p>
		<input type="submit" value="Summit" />
	</p>
</form>