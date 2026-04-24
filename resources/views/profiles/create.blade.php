<!DOCTYPE html>
<html>
<head>
    <title>Add Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            background: #0d6efd;
            color: white;
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
                    ➕ Add New Profile
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="/profiles/store">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/profiles" class="btn btn-secondary">← Back</a>
                            <button class="btn btn-success">Save</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>