<?php
function homePath($isReturn = false) {
	$selfPath = substr($_SERVER['PHP_SELF'], 1);
  $path = substr($_SERVER['REQUEST_URI'], 1);//remove / slash
  $countSlash = substr_count($path,"/") - substr_count($selfPath,"/");
  if($isReturn) return str_repeat("../", $countSlash);
  echo str_repeat("../", $countSlash);
}

function realFilePath() {
	$selfPath = substr($_SERVER['PHP_SELF'], 1);
  $path = substr($_SERVER['REQUEST_URI'], 1);//remove / slash
  $countSlash = substr_count($selfPath,"/") ;
  return str_repeat("../", $countSlash);
}
function repeatSlash() {
	$selfPath = substr($_SERVER['PHP_SELF'], 1);
  $path = substr($_SERVER['REQUEST_URI'], 1);//remove / slash
  $countSlash = substr_count($path,"/") - substr_count($selfPath,"/") ;
  return str_repeat("../", $countSlash > 0 ? $countSlash - 1 : 0);
}

function validateLogin($isDie = false, $dieOnAuthenticated = false) {
  if(isset($_SESSION['email'])) {
    if($isDie && $dieOnAuthenticated)
      die('<script type="text/javascript">
      window.location = "'.homePath(true).'";
      </script>');
    return true;
  }
  if($isDie && !$dieOnAuthenticated)
  die('<script type="text/javascript">
    window.location = "'.homePath(true).'";
    </script>');
  return false;
}

function renderBody() {
  if(isset($_SESSION['email'])) {
    include(__DIR__."/../pages/accountsidebar.php");
  }
  $path = $_SERVER['REQUEST_URI'];//remove / slash
  $path = parse_url($path, PHP_URL_PATH);//only get url path
  if($path && file_exists(__DIR__."/../".realFilePath().$path.".php")){
    include(__DIR__."/../".realFilePath().$path.".php");
  }
  else {
    if(isset($_SESSION['email'])) {
      include(__DIR__."/../pages/home.php");
    } else {
      redirectRoute('pages/auth/login');
    }
  }
  if(isset($_SESSION['email'])) {
    include(__DIR__."/../pages/footer.php");
  }
}

function redirectRoute($url) {
  die('<script type="text/javascript">
  window.location = "'.homePath(true).$url.'";
  </script>');
}

function renderNavbar() {
  if(isset($_SESSION['email'])) {
    include(__DIR__."/../pages/navbar.php");
  } 
}
?>