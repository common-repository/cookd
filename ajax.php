<?php

  require_once('../../../wp-admin/admin.php');

	switch($_REQUEST['action']) {
		case 'opt': 
        $id = $_REQUEST['id'];
        $val = $_REQUEST['val'];
        if ($val!='out') $val='in';

        if ( ! update_post_meta ($id, 'cookdopt', $val ) ) add_post_meta( $id, 'cookdopt', $val );
				echo $val;
		break;

		default: echo 'no action';
	}

?>