function avalidateForm() {
    let a = document.forms["aForm"]["ag_settings"].value;
    let b = document.forms["aForm"]["age_dialog_title"].value;
    let c = document.forms["aForm"]["edialog"].value;
    let d = document.forms["aForm"]["age_confirm_text"].value;
    let e = document.forms["aForm"]["age_decline_text"].value;

    var aerror = document.getElementById("aerror");
    if (a == "") {
        aerror.textContent = "*fill update young age";
        aerror.style.color = "red";
      return false;
    }
  
    var aderror = document.getElementById("aderror");
    if (b == "") {
        aderror.textContent = "*fill title for show popup";
        aderror.style.color = "red";
      return false;
    }
    var aterror = document.getElementById("aterror");
    if (c == "") {
        aterror.textContent = "*fill text for popup view";
        aterror.style.color = "red";
      return false;
    }
    var aberror = document.getElementById("aberror");
    if (d == "") {
        aberror.textContent = "*fill confirm button txt";
        aberror.style.color = "red";
      return false;
    }
    var abderror = document.getElementById("abderror");
    if (e == "") {
        abderror.textContent = "*fill decline button txt";
        abderror.style.color = "red";
      return false;
    }
    return true;
  }