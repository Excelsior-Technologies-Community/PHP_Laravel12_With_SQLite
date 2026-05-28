{{-- resources/views/profiles/index.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Advanced Profiles Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { margin-top: 30px; margin-bottom: 30px; }
        .header-box { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .search-box { border-radius: 12px; padding-left: 40px; }
        .search-icon { position: absolute; margin-left: 12px; margin-top: 12px; color: gray; }
        .card { border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: bold; }
        .table thead { background: #2c3e50; color: white; }
        .table tbody tr:hover { background: #f8f9fa; transition: 0.3s; }
        .btn-sm { border-radius: 8px; margin: 0 2px; }
        .profile-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .badge { padding: 5px 10px; border-radius: 10px; }
        .action-buttons { white-space: nowrap; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-box">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"> Profiles Dashboard</h4>
                <div>
                    <a href="/profiles/export" class="btn btn-success me-2"> Export CSV</a>
                    <a href="/profiles/trashed" class="btn btn-info me-2"> Trashed</a>
                    <a href="/profiles/create" class="btn btn-primary"> Add Profile</a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="position-relative">
                       
                        <input type="text" id="search" class="form-control search-box shadow-sm" placeholder="Search by name, email or phone...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="status-filter" class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button id="bulk-delete-btn" class="btn btn-danger w-100" disabled> Delete Selected</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
               All Profiles
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="50"><input type="checkbox" id="select-all"></th>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach($profiles as $profile)
                            <tr>
                                <td><input type="checkbox" class="profile-checkbox" value="{{ $profile->id }}"></td>
                                <td>{{ $profile->id }}</td>
                                <td>
                                    <img src="{{ $profile->profile_image_url }}" class="profile-img" alt="Profile">
                                </td>
                                <td class="fw-semibold">{{ $profile->name }}</td>
                                <td>{{ $profile->email }}</td>
                                <td>{{ $profile->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $profile->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($profile->status) }}
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <a href="/profiles/show/{{ $profile->id }}" class="btn btn-info btn-sm" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="/profiles/edit/{{ $profile->id }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="/profiles/delete/{{ $profile->id }}" class="btn btn-danger btn-sm delete-btn" title="Delete"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="pagination" class="d-flex justify-content-center mt-4">
            {{ $profiles->links() }}
        </div>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    <script>
        let searchInput = document.getElementById('search');
        let statusFilter = document.getElementById('status-filter');
        let tableBody = document.getElementById('table-body');
        let pagination = document.getElementById('pagination');
        let selectAll = document.getElementById('select-all');
        let bulkDeleteBtn = document.getElementById('bulk-delete-btn');

        function loadData(page = 1) {
            let search = searchInput.value;
            let status = statusFilter.value;
            
            fetch(`/profiles?search=${search}&status=${status}&page=${page}`)
                .then(res => res.json())
                .then(res => {
                    let rows = '';
                    if (res.data.length > 0) {
                        res.data.forEach(profile => {
                            rows += `
                            <tr>
                                <td><input type="checkbox" class="profile-checkbox" value="${profile.id}"></td>
                                <td>${profile.id}</td>
                                <td><img src="${profile.profile_image_url || '/default-avatar.png'}" class="profile-img"></td>
                                <td class="fw-semibold">${profile.name}</td>
                                <td>${profile.email}</td>
                                <td>${profile.phone || 'N/A'}</td>
                                <td><span class="badge bg-${profile.status == 'active' ? 'success' : 'danger'}">${profile.status.toUpperCase()}</span></td>
                                <td>
                                    <a href="/profiles/show/${profile.id}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                    <a href="/profiles/edit/${profile.id}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                    <a href="/profiles/delete/${profile.id}" class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>`;
                        });
                    } else {
                        rows = `<tr><td colspan="8" class="text-center">No Records Found</td></tr>`;
                    }
                    tableBody.innerHTML = rows;
                    pagination.innerHTML = res.links;
                    attachPaginationEvents();
                    attachDeleteEvents();
                    updateBulkDeleteButton();
                });
        }

        function attachDeleteEvents() {
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let url = this.href;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });
        }

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

        function updateBulkDeleteButton() {
            let checkboxes = document.querySelectorAll('.profile-checkbox');
            let checked = Array.from(checkboxes).some(cb => cb.checked);
            bulkDeleteBtn.disabled = !checked;
        }

        searchInput.addEventListener('keyup', () => loadData());
        statusFilter.addEventListener('change', () => loadData());
        
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.profile-checkbox').forEach(cb => {
                cb.checked = selectAll.checked;
            });
            updateBulkDeleteButton();
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('profile-checkbox')) {
                updateBulkDeleteButton();
                let allChecked = Array.from(document.querySelectorAll('.profile-checkbox')).every(cb => cb.checked);
                selectAll.checked = allChecked;
            }
        });

        bulkDeleteBtn.addEventListener('click', function() {
            let selectedIds = Array.from(document.querySelectorAll('.profile-checkbox:checked')).map(cb => cb.value);
            
            if (selectedIds.length === 0) return;
            
            Swal.fire({
                title: 'Delete Selected Profiles?',
                text: `You are about to delete ${selectedIds.length} profile(s). This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/profiles/bulk-delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message, 'success');
                            loadData();
                        }
                    });
                }
            });
        });

        attachDeleteEvents();
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
</html>