<!DOCTYPE html>
<html>
<head>
    <title>Add Profile</title>

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
                <div class="card-header bg-primary text-white text-center">
                    <h4>Add Profile</h4>
                </div>

                <div class="card-body">

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
                            <button class="btn btn-success">Save</button>
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
