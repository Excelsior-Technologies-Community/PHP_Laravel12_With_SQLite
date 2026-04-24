<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            background: #ffc107;
            color: black;
            font-weight: bold;
            text-align: center;
            font-size: 18px;
        }

        .container {
            margin-top: 80px;
        }

        .btn {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card">
                <div class="card-header">
                    ✏ Edit Profile
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="/profiles/update/{{ $profile->id }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ $profile->name }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ $profile->email }}" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/profiles" class="btn btn-secondary">← Back</a>
                            <button class="btn btn-success">Update</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>