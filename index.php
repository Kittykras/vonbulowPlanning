<?php
include 'include/top.inc.php';
?>
<link rel="stylesheet" href="login.css">
<div class="vertically-align" align="center">
    <form role="form" action="checkLogin.php" method="post">
    <div class="form-group">
        <input name="user" type="user" class="form-control" id="user" placeholder="Brugernavn" autocomplete="on">
    </div>
    <div class="form-group">
        <input name="pwd" type="password" class="form-control" id="pwd" placeholder="Kodeord" autocomplete="on">
    </div>
    <button type="submit" class="btn btn-black">Log Ind</button>
  </form>
</div>

</body>
</html>
<?php
if(isset($_GET["error"])){
    echo 'Wrong username or password';
}
?>