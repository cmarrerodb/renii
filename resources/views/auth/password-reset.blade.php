<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Clave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            @if($valido ==1 && $vigente == 1)
                <div class="col-md-8">
                    <div class="card" style="margin-top:30% !important;">
                        <div class="card-header">{{ __('Actualizar Clave') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" required value="{{ $email }}" readonly style = "background-color:#dadee6;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Clave') }}<span style="color:red;font-weight:bold;">*</span></label>
                                    <div class="col-md-6" style="margin-top:3%;">
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="off" style="background-color:#f2f0df;" value="">
                                        <div id="pass_error" style="color:red;font-size:70%;margin-bottom:5%;"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Clave') }}<span style="color:red;font-weight:bold;">*</label>
                                    <div class="col-md-6" style="margin-top:1%;">
                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="off" style="background-color:#f2f0df;">
                                        <div id="conf_error" style="color:red;font-size:80%;"></div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar" style="margin-top:5%;">
                                            {{ __('Actualizar') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif($valido ==0 && $vigente == 1)
                <div class="alert alert-danger mt-4" role="alert">
                    El token no existe o no coincide; por favor realice de nuevo la solicitud de reinicio de clave.
                </div>
            @elseif($valido ==1 && $vigente == 0)
                <div class="alert alert-danger mt-4" role="alert">
                    El token ha expirado; por favor realice de nuevo la solicitud de reinicio de clave.
                </div>
            @elseif($valido ==0 && $vigente == 0)
                <div class="alert alert-danger mt-4" role="alert">
                    Ha ocurrido un error; por favor realice de nuevo la solicitud de reinicio de clave.
                </div>
            @endif
        </div>
    </div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    |<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegúrate de incluir la biblioteca jQuery -->
    <script>
        $(document).ready(function() {
            $("#password").val('');
            $("#password_confirmation").val('');
            function validarPassword() {
                var password = $("#password").val();
                regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.\-_,()=#|[\]{}])[A-Za-z\d@$!%*?&.\-_,()=#|[\]{}]{8,}$/;
                var errores = [];
                if (!regex.test(password)) {
                    if (password.length < 8) {
                        errores.push("Debe tener al menos 8 caracteres");
                    }
                    if (!/[a-z]/.test(password)) {
                        errores.push("Debe tener al menos una minúscula");
                    }
                    if (!/[A-Z]/.test(password)) {
                        errores.push("Debe tener al menos una mayúscula");
                    }
                    if (!/\d/.test(password)) {
                        errores.push("Debe tener al menos un número");
                    }
                    if (!/[@$!%*?&.\-_,()=#|[\]{}]/.test(password)) {
                        errores.push("Debe tener al menos un caracter especial");
                    }
                }
                return errores;
            }
            function validarConfirmacion() {
                var password = $("#password").val();
                var confirmacion = $("#password_confirmation").val();
                if (password !== confirmacion) {
                    return ["Los campos password y confirmación deben coincidir"];
                }
                return [];
            }
            function habilitarGuardar() {
                var erroresPassword = validarPassword();
                var erroresConfirmacion = validarConfirmacion();
                if (erroresPassword.length === 0 && erroresConfirmacion.length === 0) {
                    $("#pass_error").html("");
                    $("#conf_error").html("");
                    $("#btn_guardar").prop("disabled", false);
                } else {
                    $("#pass_error").html(erroresPassword.join("<br>"));
                    $("#conf_error").html(erroresConfirmacion.join("<br>"));
                    $("#btn_guardar").prop("disabled", true);
                }
            }
            $("#password").keyup(function() {
                var errores = validarPassword();
                $("#pass_error").html(errores.join("<br>"));
                habilitarGuardar();
            });
            $("#password_confirmation").keyup(function() {
                var errores = validarConfirmacion();
                $("#conf_error").html(errores.join("<br>"));
                habilitarGuardar();
            });
            $("#password").blur(function() {
                var errores = validarPassword();
                $("#pass_error").html(errores.join("<br>"));
                habilitarGuardar();
            });
            $("#password_confirmation").blur(function() {
                var errores = validarConfirmacion();
                $("#conf_error").html(errores.join("<br>"));
                habilitarGuardar();
            });
        });
    </script>
</body>
</html>
