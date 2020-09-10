<?php

/*
 * Print edit subnet
 *********************/


/* functions */
require_once( dirname(__FILE__) . '/../../../functions/functions.php' );

# initialize user object
$Database 	= new Database_PDO;
$User 		= new User ($Database);
$Admin	 	= new Admin ($Database, false);
$Sections	= new Sections ($Database);
$Subnets	= new Subnets ($Database);
$Tools		= new Tools ($Database);
$Result 	= new Result ();

# verify that user is logged in
$User->check_user_session();

# create csrf token
$csrf = $_POST['action']=="add" ? $User->Crypto->csrf_cookie ("create", "subnet_add") : $User->Crypto->csrf_cookie ("create", "subnet_".$_POST['subnetId']);

# strip tags - XSS
$_POST = $User->strip_input_tags ($_POST);

$subnet = $Subnets->fetch_subnet(null, $_POST['subnetId']);

?>

<!-- header -->
<div class="pHeader"><?php print ucwords(_("$_POST[action]")); ?> <?php print _('subnet'); ?></div>

<!-- content -->
<div class="pContent">
<form id="swipSubnetDetails">
		<table class="swipSubnetDetails table table-noborder table-condensed">

			<!-- subnet -->
			<tr>
					<td class="middle"><?php print _('Subnet'); ?></td>
					<td>
							<input type="text" class="form-control input-sm input-w-200" id="subnet" disabled name="subnet"  value="<?php print _($subnet->ip.'/'.$subnet->mask); ?>">
					</td>
					<td class="info2"><?php print _('Subnet to swip'); ?></td>
			</tr>

		</table>
	</form>
	<div class="alert alert-success swipMessage" style="visibility: hidden"></div>
</div>

<!-- footer -->
<div class="pFooter">
	<div class="btn-group">
		<button class="btn btn-sm btn-default hidePopups"><?php print _('Cancel'); ?></button>
		<button id="swipBtnSubmit" type="submit" class="btn btn-sm btn-default swipSubnetSubmit btn-success"><i class="fa fa-check"></i> <?php print ucwords(_($_POST['action'])); ?></button>
	</div>

	<div class="manageSubnetSwipResult"></div>
</div>
