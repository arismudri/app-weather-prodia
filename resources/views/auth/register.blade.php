<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Prodia - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ url('/assets/template') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ url('/assets/template') }}/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                <h6 id="error-messages" style="color: red"></h6>
                            </div>
                            <form class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="field-name"
                                        placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="field-email"
                                        placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="field-password"
                                        placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Register
                                    Account</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ url('/login-view') }}">Already have an
                                    account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ url('/assets/template') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ url('/assets/template') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url('/assets/template') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url('/assets/template') }}/js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            let urlRegister = "{{ url('/api/register') }}";
            let urlLogin = "{{ url('/login-view') }}";
            let ErrorMessages = $("#error-messages");

            $("form").submit(function(e) {
                ErrorMessages.empty();
                e.preventDefault();
                $.ajax({
                    url: urlRegister,
                    method: "POST",
                    data: {
                        name: $("#field-name").val(),
                        email: $("#field-email").val(),
                        password: $("#field-password").val(),
                    },
                }).done(function(response) {

                    window.location.replace(urlLogin);

                }).fail(function(err) {
                    Object.keys(err.responseJSON.error).forEach(key => {
                        ErrorMessages.append(err.responseJSON.error[key]);
                    });
                    console.log({
                        err
                    });
                });
            });
        });
    </script>

</body>

</html>