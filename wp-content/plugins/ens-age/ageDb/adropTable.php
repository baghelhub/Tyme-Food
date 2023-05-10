<?php
     
     global $wpdb;
     $dropTable = $wpdb->prefix . 'ensage';
     $sql = "DROP TABLE IF EXISTS $dropTable;";
     $wpdb->query($sql);
     delete_option("my_plugin_db_version");
     
?>  
