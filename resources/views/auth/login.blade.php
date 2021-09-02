<!DOCTYPE html>
<html lang="en">

<head>
  @include('_partials.header')
  @include('_partials.css_asset')
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container password-reset-container">
        <div class="row px-5">
            <div class="col-md-6 offset-md-3 white-bg pad-4 pt-5">
              <div class="card shadow-sm" style="border-radius: 20px; border-bottom:3px solid #126afe">
                <div class="card-body">
                  <h4 class="text-dark font-weight-normal mt-4">Selamat Datang <span class="font-weight-bold"></span></h4>
                  <form method="POST" action="{{route('auth.index.post')}}" class="needs-validation mt-4" novalidate="">
                    @csrf
                    <div class="form-group">
                      <label class="form-label">Role</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="role" value="admin" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon">Admin</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="role" value="wadir3" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon">Wadir 3</span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email">Username</label>
                      <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                      <div class="invalid-feedback">
                        Please fill in your username
                      </div>
                    </div>
      
                    <div class="form-group">
                      <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                      </div>
                      <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                      <div class="invalid-feedback">
                        please fill in your password
                      </div>
                    </div>
      
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                      </div>
                    </div>
      
                    <div class="form-group text-right">
                      <a href="auth-forgot-password.html" class="float-left mt-3">
                        Forgot Password?
                      </a>
                      <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                        Login
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>
    </section>
  </div>



  <!-- Page Specific JS File -->
  @include('_partials.js')

  <script>
    //   const chooseRole = (role) => {
    //     $('#role_'+role).removeClass('btn btn-primary');
    //     $('#role_'+role).addClass('selected btn btn-success');
    //       $('.btn-role').each(function(){
    //         if(!$(this).hasClass('selected')){
    //             $(this).removeClass('btn btn-primary');
    //             $(this).addClass('selected btn btn-success');
    //         }else{
    //             $(this).addClass('btn btn-primary');
    //             $(this).removeClass('selected btn btn-success');
    //         }
    //       });
    //   }
  </script>

</body>

</html>