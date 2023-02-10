<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>QR Code แบบประเมินความพึงพอใจ</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body>

    <div class="container mt-4">

        <div class="card">

            <div class="card-body text-center">
                {!! QrCode::size(300)->generate($url) !!}
            </div>

        </div>



    </div>
</body>
</html>
