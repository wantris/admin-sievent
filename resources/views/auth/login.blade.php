<!DOCTYPE html>
<html lang="en">

<head>
  @include('_partials.header')
  @include('_partials.css_asset')
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
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
        <div
          class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
          data-background="../assets/img/unsplash/login-bg.jpg">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <h1 class="mb-2 display-4 font-weight-bold">Good Morning</h1>
                <h5 class="font-weight-normal text-muted-transparent">Bali, Indonesia</h5>
              </div>
              Photo by <a class="text-light bb" target="_blank" href="https://unsplash.com/photos/a8lTjWJJgLA">Justin
                Kauffman</a> on <a class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a>
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