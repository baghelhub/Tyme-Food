<?php
      global $table_prefix, $wpdb;
      $agetable = $wpdb->prefix."ensage";
 
	     if( $wpdb->get_var( "show tables like '$agetable'" ) != $agetable ) {
           $sql  =   "CREATE TABLE `$agetable`(
          `e_id` int(11) NOT NULL,
          `age` int(11) NOT NULL,
          `title` varchar(255) NOT NULL,
          `diagtext` text NOT NULL,
          `confirm` varchar(255) NOT NULL,
          `Decline` varchar(255) NOT NULL,
        
           UNIQUE KEY id (e_id)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
         
              /* Include Upgrade Script **************/
		  require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		  dbDelta( $sql );   
      }
?>