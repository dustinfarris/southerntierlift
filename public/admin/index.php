<?php /*login file for STL Administration portal */
include("./header.php");
?>
<div id="content">
	<form action="./verify.php" method="post">
		<table>
			<tr>
				<td>Login:</td>
				<td>
					<input type="text" name="email" size="30">
				</td>
			</tr>
			<tr>
				<td>Password:</td>
				<td>
					<input type="password" name="password" size="30">
				</td>
			</tr>
		</table>
		<input type="submit" name="mode" value="Log In" />
	</form>
</div>

<?php  include("../footer.php"); ?>
