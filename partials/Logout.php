<?php


$logout = new Authenticate("", "", "");
$logout->Logout();
//header('Refresh: 1; url=index.php');


?>
<div class="cobtainer">
<div class="alert alert-danger alert-dismissable fade in">
    <a href="/index.php" class="close" data-dismiss="alert" aria-label="close"></a>
    <strong>Logout!</strong> Your session is finished! Login again!->
    <button onclick="myFunction()" class="btn btn-success">Login Again!</button>
  </div>
</div>    

<script>
function myFunction() {
    location.reload();
}
</script>
