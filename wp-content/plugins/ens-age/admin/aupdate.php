<?php

      global $wpdb;
      $table = $wpdb->prefix . "ensage";
      $age      =  sanitize_text_field($_POST["ag_settings"]);
      $title    =  sanitize_text_field($_POST["age_dialog_title"]);
      $diagtext =  sanitize_textarea_field($_POST["edialog"]);
      $confirm  =   sanitize_text_field($_POST["age_confirm_text"]);
      $Decline  =   sanitize_text_field($_POST["age_decline_text"]);
      $getId = sanitize_text_field($_POST["getId"]);    
      
      if(isset($_POST["age-submit"])) {
      $qu = $wpdb->query( $wpdb->prepare( 
              "UPDATE {$table} 
               SET age = %d, title = %s, diagtext = %s, confirm = %s, Decline = %s
               WHERE e_id = %d;",
               $age, $title, $diagtext, $confirm, $Decline, $getId
        ) );
          if($qu) {   echo "";
             
          } else {    echo "";
      
        }

   }