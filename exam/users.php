<?php
include('includes/config.php');
include('includes/user.class.php');


// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');

//ERROR MESSAGE CODE
$errmsg = '';	


if(isset($_GET['msg']) && $_GET['msg']=='useradded'){
	$errmsg='User successfully added';
}

if(isset($_GET['msg']) && $_GET['msg']=='updated'){
	$errmsg='User successfully updated';
}


if(isset($_GET['action']) && $_GET['action']=='activate'){
	$usr->activateUser($_GET['id']);
	$errmsg='User successfully activated.';
}

if(isset($_GET['action']) && $_GET['action']=='block'){
	$usr->deActivateUser($_GET['id']);
	$errmsg='User successfully De-activated.';
}

if(isset($_GET['action']) && $_GET['action']=='delete'){
	$usr->deleteUser($_GET['id']);
	$errmsg='User successfully Deleted.';
}



include('includes/header.php');
?>

<!-- JAVA SCRIPT TO CONFIRM THE DELETE ACTION -->
<script language="javascript">
function conf_del(id){
	var conf = window.confirm('Are you sure that you want to delete this user?');
	if(conf)
	{
		window.location='users.php?action=delete&id='+id;
	}
}
</script>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu">
		<?php include('includes/leftmenu.php'); ?>
	</td>
	<td>
		
		<div class="list">
			<?php if(trim($errmsg)!='') echo '<span class="errormsg">'.$errmsg.'</span><br />' ?>
			<table cellpadding="0" cellspacing="0">
			<tr><td colspan="2" class="table_title">User List</td><td colspan="4" class="table_options"><img src="images/add2.png"><a href="add_user.php">Add User</a></td></tr>
			<tr class="table_header"><td>First Name</td><td>Last Name</td><td>Email</td><td>User Type.</td><td>Status</td><td>Options</td></tr>	
			<?php
				//$color="#3399ff";
				$color="#000000";
				$arr = $usr->getUserList();
				foreach($arr as $val){
					if($val['user_type_name']=='Faculty')
					{
						//$color="#33999f";
						$color="#444444";
					}
					elseif($val['user_type_name']=='DEO')
					{
						//$color="#33ffff";
						$color="#000000";
					}
					else if($val['user_type_name']=='Student')
					{
						$color="#999999";
					}
					$status = ($val['isactive']=='0')?'<span class="errormsg">In Active</span>':'Active';
					echo "<tr class=\"table_row\" style=\"background-color:$color; color:white;\"><td>$val[first_name]</td><td>$val[last_name]</td><td>$val[email]</td><td>$val[user_type_name]</td><td>$status</td>";
					if(intval($val['user_id'])!=1)
					{
						if(intval($val['isactive'])==1) echo "<td><a href=\"users.php?action=block&id=$val[user_id]\" title=\"Block User\"><img src=\"images/forbidden.png\" style=\"border:0px;\" alt=\"Block User\"></a>&nbsp;";
						else echo "<td><a href=\"users.php?action=activate&id=$val[user_id]\" title=\"Activate User\"><img src=\"images/checks.png\" style=\"border:0px;\" alt=\"Actiavte User\"></a>&nbsp;";
						echo "<a href=\"edit_users.php?id=$val[user_id]\" title=\"Edit User\"><img src=\"images/edit.png\" style=\"border:0px;\" alt=\"Edit User\"></a>&nbsp;";
						echo "<a href=\"javascript:conf_del($val[user_id])\" title=\"Delete User\"><img src=\"images/delete2.png\" style=\"border:0px;\" alt=\"Delete User\"></a></td>";
					}
					else
						echo '<td>&nbsp;</td>';
					echo "</tr>";
				}
			?>
			</table>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>