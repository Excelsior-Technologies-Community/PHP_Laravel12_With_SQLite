{{-- resources/views/profiles/trashed.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Trashed Profiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-warning">
                <h4>Deleted Profiles</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profiles as $profile)
                        <tr>
                            <td>{{ $profile->id }}</td>
                            <td>{{ $profile->name }}</td>
                            <td>{{ $profile->email }}</td>
                            <td>{{ $profile->deleted_at }}</td>
                            <td>
                                <a href="/profiles/restore/{{ $profile->id }}" class="btn btn-success">Restore</a>
                                <button onclick="permanentDelete({{ $profile->id }})" class="btn btn-danger">Permanent Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $profiles->links() }}
                <a href="/profiles" class="btn btn-primary">Back to Profiles</a>
            </div>
        </div>
    </div>
    
    <script>
        function permanentDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete permanently!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/profiles/force-delete/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    </script>
</body>
</html>