      <div class="authentication-inner py-6 mx-4">
        <!-- Login -->
        <div class="card p-7">
          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5">
            <a href="index.html" class="app-brand-link gap-3">
              <span class="app-brand-text demo text-heading fw-semibold">Please Register</span>
            </a>
          </div>
          <!-- /Logo -->

          <div class="card-body mt-5">

            <form id="registerForm" class="mb-5">
              <div class="form-floating form-floating-outline mb-5">
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  name="username"
                  placeholder="Enter your username"
                  autofocus />
                <label for="username">Username</label>
              </div>
              <div class="form-floating form-floating-outline mb-5">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" />
                <label for="email">Email</label>
              </div>
              <div class="mb-5 form-password-toggle">
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
                  <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
                </div>
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100 mb-5">Register</button>
          </div>
          </form>

          <p class="text-center mb-5">
            <span>Sudah punya akun?</span>
            <a href="#" id="loginButton">
              <span>silahkan login</span>
            </a>
          </p>
        </div>
      </div>
      </div>

      <script>
        $('#loginButton').click(function() {
          $('#content').load('login.php')
        })

        $('#registerForm').submit(function(e) {
          e.preventDefault();
          $.ajax({
            url: 'register_process.php',
            method: 'POST',
            data: {
              username: $('#username').val(),
              email: $('#email').val(),
              password: $('#password').val()
            },
            dataType: 'json',
            success: function(response) {
              console.log(response);
              if (response.status == 'success') {
                // sweet alert
                Swal.fire({
                  title: "Good job!",
                  text: response.message,
                  icon: "success"
                }).then((result) => {
                  if (result.isConfirmed) {
                    $('#content').load('login.php')
                  }
                })
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
              Swal.fire({
                title: "Oops!",
                text: "Registrasi gagal, silahkan coba lagi.",
                icon: "error"
              })
            }
          });
        });
      </script>