
<table>
	<thead>
    <tr>
      <th width="300"><center>Players</center></th>
    </tr>
  </thead>
<?php 
	if ($users) {
		foreach ($users as $user) {
			if ($user->id != $currentUser->id) {
?>			

			<tr>
				<td style="background-color:#D0D0D0"> 
				<center>
				<?= anchor("arcade/invite?login=" . $user->login,$user->fullName()) ?> 
				</center>
				</td>
			</tr>

<?php 	
			}
		}
	}
?>

</table>