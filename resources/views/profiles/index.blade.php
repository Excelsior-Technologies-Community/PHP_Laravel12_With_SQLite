<!DOCTYPE html>
<html>
<head>
    <title>Profiles</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h3>Profile List</h3>
        <a href="/profiles/create" class="btn btn-primary">+ Add Profile</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($profiles as $profile)
                    <tr>
                        <td>{{ $profile->id }}</td>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->email }}</td>
                        <td>
                            <a href="/profiles/edit/{{ $profile->id }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/profiles/delete/{{ $profile->id }}"
                               onclick="return confirm('Are you sure?')"
                               class="btn btn-sm btn-danger">
                               Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if(count($profiles) == 0)
                    <tr>
                        <td colspan="4" class="text-center">No Records Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>
