<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Clave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            @if(Session::has('success_message'))
                <div class="alert alert-success mt-4" role="alert">
                    {{ Session::get('success_message') }}
                </div>
            @endif
        </div>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>    
</body>
</html>