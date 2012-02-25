<?php
$zing_mailz_name = "Mailing List";
$zing_mailz_shortname = "zing_mailz";
$zing_mailz_options=array();

function zing_mailz_upgrade() {
	global $zing_mailz_name, $zing_mailz_shortname, $zing_mailz_options;

	zing_mailz_activate();
	foreach ($zing_mailz_options as $value) {
		if( isset( $_REQUEST[ $value['id'] ] ) ) {
			update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
		} else delete_option( $value['id'] );
	}
	header("Location: admin.php?page=mailz_cp");
	die();
}

function zing_mailz_install() {
	global $zing_mailz_name, $zing_mailz_shortname, $zing_mailz_options;

	if ($_GET['action']=='install') {
		zing_mailz_activate();
		foreach ($zing_mailz_options as $value) {
			if( isset( $_REQUEST[ $value['id'] ] ) ) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
			} else { delete_option( $value['id'] );
			}
		}
		header("Location: admin.php?page=mailz_cp&installed=true");
		die();
	} else {
		$message='<p>Ready to install this plugin? Simply click on the button below and wait a few seconds.</p><br />';
		$message.='<a href="admin.php?page=mailz_cp&action=install" class="button">Install</a><br />';
		zing_mailz_cp($message);
	}
}

function zing_mailz_admin_menu() {
	global $zing_mailz_name, $zing_mailz_shortname, $zing_mailz_options;
	global $zing_mailz_content;
	global $zing_mailz_menu;

	if (!class_exists('simple_html_dom_node')) require(dirname(__FILE__) . '/addons/simplehtmldom/simple_html_dom.php');
	$zing_mailz_version=get_option("zing_mailz_version");

	if (isset($_GET['action']) && $_GET['action']=='install' && isset($_GET['page']) && $_GET['page']=='mailz_cp') zing_mailz_install();
	
	if (empty($_GET['zlist'])) $_GET['zlist']='admin/index';
	if (!empty($_REQUEST['page']) && $_REQUEST['page'] != 'mailz_cp') {
		$_GET['zlistpage']=str_replace('mailz-','',$_REQUEST['page']);
		$_GET['zlist']='index';
	}

	if (get_option("zing_mailz_version")) {
		add_menu_page($zing_mailz_name, $zing_mailz_name, 'administrator', 'mailz_cp','zing_mailz_admin');
		if ($zing_mailz_version != ZING_MAILZ_VERSION) add_submenu_page('mailz_cp', $zing_mailz_name.'- Upgrade', 'Upgrade', 'administrator', 'mailz-upgrade', 'zing_mailz_upgrade');
		else {zing_mailz_header();
			$html=str_get_html($zing_mailz_menu);
			$first=true;
			foreach($html->find('a') as $e) {
				$link=str_replace("admin.php?page=mailz_cp&zlist=index&zlistpage=","",$e->href);
				$label=ucfirst($e->innertext);
				if ($first) add_submenu_page('mailz_cp', $zing_mailz_name.'- '.$label, $label, 'administrator', 'mailz_cp', 'zing_mailz_admin');
				elseif (substr($link,0,3)!='div') {
					add_submenu_page('mailz_cp', $zing_mailz_name.'- '.$label, $label, 'administrator', 'mailz-'.$link, 'zing_mailz_admin');
				}
				$first=false;
			}
		}
	} else {
		add_menu_page($zing_mailz_name, $zing_mailz_name, 'administrator', 'mailz_cp','zing_mailz_install');
		add_submenu_page('mailz_cp', $zing_mailz_name.'- Install', 'Install', 'administrator', 'mailz_cp', 'zing_mailz_install');
	}
}

function zing_mailz_admin() {
	global $zing_mailz_name, $zing_mailz_shortname, $zing_mailz_options, $wpdb;

	if ( isset($_REQUEST['installed']) && $_REQUEST['installed'] ) echo '<div id="message" class="updated fade"><p><strong>'.$zing_mailz_name.' installed.</strong></p></div>';

	$zing_mailz_version=get_option("zing_mailz_version");

	zing_mailz_cp();
}

function zing_mailz_cp($message='') {
	global $zing_mailz_content,$zing_mailz_name,$zing_mailz_menu;

	$zing_mailz_version=get_option("zing_mailz_version");
	
	zing_mailz_head();
	
	echo '<div class="wrap">';
	echo '<div id="zing-mailz-cp-content">';
	if ($message) {
		echo '<h2><b>'.$zing_mailz_name.' - '.$_GET['zlistpage'].'</b></h2>';
		echo $message;
	} elseif ($zing_mailz_version) {
		if (isset($_GET['zlistpage']) && $_GET['zlistpage']=='admin') {
			echo 'Please use the <a href="users.php">Wordpress Users menu</a> to change <strong>admin</strong> user details';
		} else {
			echo '<div id="phplist">'.$zing_mailz_content.'</div>';
		}
	}
	echo '</div>';
	
	require(dirname(__FILE__).'/includes/support-us.inc.php');
	zing_support_us('mailing-list','mailz','mailz_cp',ZING_MAILZ_VERSION);
	
	echo '</div>';
?><div style="clear: both"></div>
<hr />
<p>For more info and support, contact us at <a href="http://www.zingiri.net/">Zingiri</a> or
check out our <a href="http://zingiri.net/forums/">support forums</a>.</p>
<hr />
<?php
}

add_action('admin_menu', 'zing_mailz_admin_menu', 10); ?>