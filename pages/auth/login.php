<?php
validateLogin(true, true);
?>

<div class="page-content d-flex align-items-center justify-content-center">
  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pr-md-0">
            <div class="auth-left-wrapper">

            </div>
          </div>
          <div class="col-md-8 pl-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo logo-light d-block mb-2">Ragnarok<span>AdminPanel</span></a>
              <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
              <form id="loginForm" class="needs-validation" method="post">
                <div class="form-group has-feedback">
                  <label for="email" class="control-label">Email address</label>
                  <input type="text"  pattern="^[_A-z0-9.@]{1,}$" maxlength="60" class="form-control" id="email" name="email" placeholder="Email" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                  <label for="password">Password</label>
                  <input type="password" pattern="^[_A-z0-9]{1,}$" maxlength="60" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="Password" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                <!--div class="form-check form-check-flat form-check-primary">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input">
                    Remember me
                  </label>
                </div-->
                <div class="mt-3">
                  <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">
                    Login
                  </button>
                </div>
                <!--a href="<?php homePath()?>pages/auth/register" class="d-block mt-3 text-muted">Not a user? Sign up</a-->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$().ready(function() {
  $('#loginForm').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
      // handle the invalid form...
      return false;
    }
    // var data = $('#loginForm').serialize();
    $.post("<?php homePath()?>ajax/login.php", $( "#loginForm" ).serialize(), (data) => {
      if(data[0] == 'success') {
        window.location = "<?php homePath()?>";
      } else {
        Lobibox.notify("error", {
          msg: data["error"]
        });
      }
    }, "json");
    return false;
  });
});
</script>
