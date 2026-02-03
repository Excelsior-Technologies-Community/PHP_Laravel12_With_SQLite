<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            margin-top: 80px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-header bg-warning text-dark text-center">
                    <h4>Edit Profile</h4>
                </div>

                <div class="card-body">

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
                            <button class="btn btn-success">Update</button>
                            <a href="/profiles" class="btn btn-secondary">Back</a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
