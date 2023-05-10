  <?php 
    /*get data for verify popup box ***********************************/
      global $wpdb;
      $table = $wpdb->prefix . "ensage";
      $data = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table where e_id = %s",1));     
     
      foreach($data as $row) {     
    ?>
   <div id="age-verification">
    <div class="age-verification-main">
      <span class="age-title"><?php echo  esc_attr($row->title);  ?></span>
      <span class="age-main-text"><?php echo  esc_attr($row->diagtext); ?></span>
      <button class="ensage-button age-yes" onclick="ensageConfirm()"><?php echo  esc_attr($row->confirm);  ?></button>
      <button class="ensage-button age-no" onclick="ensageFailed()"><?php echo  esc_attr($row->Decline); ?></button>
     </div>
   </div>
<?php  }  ?>

 <style>
  #age-verification {
   position: fixed;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background-color: #ebe9eb;
   -webkit-transition: 500ms;
   transition: 500ms;
   z-index: 90000001;    
}
.age-verification-main {
  background-color: #33322f;
  font-family: "Source Sans Pro", sans-serif;
  color: white;
  font-size: 14pt;
  text-align: center;
  padding: 25px;
  position: relative;
  top: 10px;
  width: 500px;
  max-width: 80%;
  margin: 0 auto;
  -webkit-box-shadow: 1px 2px 9px 0px rgba(0,0,0,0.3);
  -moz-box-shadow: 1px 2px 9px 0px rgba(0,0,0,0.3);
  box-shadow: 1px 2px 9px 0px rgba(0,0,0,0.3);
  text-shadow: 0 0 7px rgba(0,0,0,0.3);
}
@media only screen and (min-height: 450px) {
  .age-verification-main {
    top: 30%;
  }
}
@media only screen and (min-width: 1000px) {
  .age-verification-main {
    top: 20%;
  }
}
@media only screen and (max-width: 720px) {
  .age-verification-main {
    top: 10%;
  }
}
.age-title, .age-main-text {
  display: block;
  margin-bottom: 1em;
}

.age-title {
  font-size: 20pt;
  margin-bottom: 0.5em;
}

.ensage-button {
  cursor: pointer; 
  -webkit-box-shadow: 1px 2px 9px 0px rgba(0,0,0,0.3);
  -moz-box-shadow: 1px 2px 9px 0px rgba(0,0,0,0.3);
  box-shadow: 1px 2px 9px 0px rgba(0,0,0,0.3);
}

.ensage-button {

  font-family: "Source Sans Pro", sans-serif;
  background-color: #857856;
  border: none;
  font-size: 10pt;
  color: white;
  display: inline-block;
  width: 150px;
  padding: 10px;
  margin: 5px 10px;
}

.age-credits {
  font-family: "Source Sans Pro", sans-serif;
  color: white;
  display: block;
  font-size: 12px;
  text-decoration: normal;
  text-align: right;
  margin-top: 20px;
  margin-bottom: -15px;
}
.age-credits a {
  color: white;
}
 </style>

 <script>
/* <span class="age-credits">Using <a href="https://ensmedicos.com">Ens Age Verification Plugin for WordPress</a></span>****/
function ageVerificationHide() {
     var agegetforverify = document.getElementById('age-verification');
         agegetforverify.style.display = 'none';
}

function ageVerificationShow() {
  var agegetforverify = document.getElementById('age-verification');
      agegetforverify.style.display = 'block';
}

function ensageConfirm() {
      var now = new Date();
      var time = now.getTime();
      var expireTime = time + 1000*36000;
         now.setTime(expireTime);
         document.cookie = 'acookie=ageCookies; expires='+now.toUTCString();
          
     return   ageVerificationHide();
 }

function ensageFailed() { 
    
       window.history.back();

    }

</script>

