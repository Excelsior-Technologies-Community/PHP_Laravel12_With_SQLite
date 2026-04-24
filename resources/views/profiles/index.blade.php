<!DOCTYPE html>
<html>

<head>
    <title>Profiles Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f3, #8e9eab);
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 40px;
        }

        /* HEADER */
        .header-box {
            background: white;
            padding: 15px 20px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* SEARCH */
        .search-box {
            border-radius: 12px;
            padding-left: 40px;
        }

        .search-icon {
            position: absolute;
            margin-left: 12px;
            margin-top: 10px;
            color: gray;
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: #0d6efd;
            color: white;
            font-weight: bold;
        }

        /* TABLE */
        .table thead {
            background: #212529;
            color: white;
        }

        .table tbody tr:hover {
            background: #f1f5ff;
            transition: 0.2s;
        }

        /* BUTTONS */
        .btn-sm {
            border-radius: 8px;
        }

        /* PAGINATION */
        .pagination {
            justify-content: center;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="header-box d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">📋 Profiles Dashboard</h4>
            <a href="/profiles/create" class="btn btn-primary">
                + Add Profile
            </a>
        </div>

        <!-- SEARCH -->
        <div class="position-relative mb-3">
            <i class="bi bi-search search-icon"></i>
            <input type="text"
                id="search"
                class="form-control search-box shadow-sm"
                placeholder="Search by name or email...">
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- TABLE CARD -->
        <div class="card">

            <div class="card-header">
                All Profiles
            </div>

            <div class="card-body p-0">

                <table class="table table-hover text-center align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="table-body">
                        @foreach($profiles as $profile)
                        <tr>
                            <td>{{ $profile->id }}</td>
                            <td class="fw-semibold">{{ $profile->name }}</td>
                            <td>{{ $profile->email }}</td>
                            <td>
                                <a href="/profiles/edit/{{ $profile->id }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="/profiles/delete/{{ $profile->id }}"
                                    onclick="return confirm('Are you sure?')"
                                    class="btn btn-danger btn-sm">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

        <!-- PAGINATION -->
        <div id="pagination" class="d-flex justify-content-center mt-4">
            <div>
                {{ $profiles->links() }}
            </div>
        </div>

    </div>

    <!-- YOUR EXISTING JS (NO CHANGE) -->
    <script>
        let searchInput = document.getElementById('search');
        let tableBody = document.getElementById('table-body');
        let pagination = document.getElementById('pagination');

        function loadData(page = 1) {
            let search = searchInput.value;

            fetch(`/profiles/search?search=${search}&page=${page}`)
                .then(res => res.json())
                .then(res => {

                    let rows = '';

                    if (res.data.length > 0) {
                        res.data.forEach(profile => {
                            rows += `
                        <tr>
                            <td>${profile.id}</td>
                            <td>${profile.name}</td>
                            <td>${profile.email}</td>
                            <td>
                                <a href="/profiles/edit/${profile.id}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="/profiles/delete/${profile.id}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    `;
                        });
                    } else {
                        rows = `<tr><td colspan="4" class="text-center">No Records Found</td></tr>`;
                    }

                    tableBody.innerHTML = rows;
                    pagination.innerHTML = res.links;

                    attachPaginationEvents();
                });
        }

        searchInput.addEventListener('keyup', function() {
            loadData();
        });

        function attachPaginationEvents() {
            document.querySelectorAll('#pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    let url = new URL(this.href);
                    let page = url.searchParams.get('page');

                    loadData(page);
                });
            });
        }
    </script>

</body>

</html>