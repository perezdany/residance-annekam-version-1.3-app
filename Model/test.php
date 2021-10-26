<?php 
  //include("../php/confige.php");
  SESSION_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="css.css">
  <link rel="stylesheet" href="../assets/css/tablestyle.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <table>
  <?php
    $c = $bdd->query("SELECT * FROM client");
    while($o = $c->fetch())
    {
      echo'<tr><td>'.$o[1].'<button type="button" class="collapsible"></button><div class="content"><p>'.$o[2].'   '.$o[3].'</p></div></td></tr>';
      echo'<tr><td></td></tr>';
    }
  ?>
  </table>
 <button type="button" class="collapsible">Open Collapsible</button>
<div class="content">
  <p>Lorem ipsum...</p>
</div> 
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
} 
</script>
</body>
</html>