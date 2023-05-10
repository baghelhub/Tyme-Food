<?php
  /* default  data insert during install pluging  ****************/
   global $wpdb;
   $agetable = $wpdb->prefix."ensage";
   $sql = $wpdb->prepare("INSERT INTO $agetable(`e_id`,`age`,`title`,`diagtext`,`confirm`,`Decline`) values (%d, %d, %s, %s, %s, %s)", 1, 21, 'Are you 21 or older ?','This website requires you to be 21 years of age or older Please verify your age to view the content or click quot Exit and quot to leave','yes 21 over','exit');
   $wpdb->query($sql);
          
   /* get data Query    ******************/
   $data = $wpdb->get_results($wpdb->prepare("SELECT * FROM $agetable where e_id = %s",1));

        foreach($data as $row) {   
         ?>

    <form method="POST" id="userForm"  name="aForm"  action="#" onsubmit="return avalidateForm()">
        <h1>Ens Age Restriction Settings</h1> 
        <table class="form-table">
        <h3 style="color:#2271b1">Default data available</h3>
          <tbody>
              <tr>
                 <td><input type="hidden" name="getId"  value="<?php echo esc_attr($row->e_id); ?>"  class="small-text ltr" </td> 
              </tr>
            
              <tr>
                <th><label>Age update</label><br><span id="aerror"></span></th>
                <td><input type="number" name="ag_settings" id="eage" value="<?php echo esc_attr($row->age); ?>" id="wp_age_gate_min_age" class="small-text ltr"> </td> 
              </tr>
            
               <tr>
                  <th><label>Dialog Title</label><br><span id="aderror"></span></th>
                  <td><input type="text" name="age_dialog_title" id="etitle" placeholder="Are you 21 or older?"  value="<?php echo esc_attr($row->title); ?>" size="50"></td>
               </tr>

                <tr>
                   <th><label>Dialog Text</label><br><span id="aterror"></span></th>
                   <td><textarea name="edialog" placeholder="This website requires you to be 21 years of age or older. Please verify your age to view the content, or click &quot;Exit&quot; to leave." name="age_dialog_text" rows="5" cols="50"><?php echo esc_attr($row->diagtext); ?></textarea></td>
               </tr>

                <tr>
                  <th><label>Button Confirm Text</label><br><span id="aberror"></span></th>
                  <td><input type="text" placeholder="I am over 21" id="econfirm" name="age_confirm_text" value="<?php echo esc_attr($row->confirm); ?>"></td>
                </tr>

                 <tr>
                   <th><label>Button Decline Text</label><br><span id="abderror"></span></th>
                   <td><input type="text" placeholder="exit" id="adecline" name="age_decline_text" value="<?php echo esc_attr($row->Decline); ?>" size="50"></td>
                 </tr>
          
                 <tr>
                   <td>
                  	  <input type="submit" name="age-submit" id="submit" class="button button-primary" value="Save Changes">
                  	  <a class="button button-info" value="Preview" style="margin-left: 10px;" onclick="window.open('http://localhost/wordpress')">Preview</a>
                    </td>
                  </tr>
             </tbody>
            </table>
         </form>
      <?php 
      }
       
      include_once(plugin_dir_path( __FILE__ ) . 'admin/aupdate.php');  /* This will output the age popup code */

       ?>