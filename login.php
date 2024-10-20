      <div class="authentication-inner py-6 mx-4">
        <!-- Login -->
        <div class="card p-7">
          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5">
            <a href="index.html" class="app-brand-link gap-3">
              <span class="app-brand-text demo text-heading fw-semibold">Welcome Back </span>
            </a>
          </div>
          <!-- /Logo -->

          <div class="card-body mt-5">

            <form id="loginForm" class="mb-5">
              <div class="form-floating form-floating-outline mb-5">
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Enter your email"
                  autofocus />
                <label for="email">Email</label>
              </div>
              <div class="mb-5">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                      <label for="password">Password</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-5">
                <button class="btn btn-primary d-grid w-100" type="submit">login</button>
              </div>
            </form>

            <p class="text-center mb-5">
              <span>Tidak punya akun?</span>
              <a href="#" id="registerButton">
                <span>Silahkan register</span>
              </a>
            </p>
          </div>
        </div>
      </div>

      <script>
        $('#registerButton').click(function() {
          $('#content').load('register.php')
        })
        $('#loginForm').submit(function(e) {
          e.preventDefault();

          $.ajax({
            url: 'login_process.php',
            method: 'POST',
            data: { 
              email: $('#email').val(),
              password: $('#password').val()
            },
            success: function(response) {
              if (response.status == 'success') {
                // sweet alert
                Swal.fire({
                  title: "Success",
                  text: response.message,
                  icon: "success"
                }).then((result) => {
                  if (result.isConfirmed)
                    window.location.href = response.redirect;
                });
              } else {
                // sweet alert
                Swal.fire({
                  title: "Oops!",
                  text: response.message,
                  icon: "error"
                });
              }
            },
            error: function(response) {
              console.log(response);
              // sweet alert
              Swal.fire({
                title: "Oops!",
                text: "login failed" + response.message,
                icon: "error"
              });
            }
          });
        });
      </script>