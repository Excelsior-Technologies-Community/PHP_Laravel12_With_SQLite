{{-- resources/views/profiles/show.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Profile Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .profile-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); margin-top: 50px; }
        .profile-img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 5px solid #667eea; }
        .info-label { font-weight: bold; color: #667eea; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-card">
                    <div class="text-center mb-4">
                        <img src="{{ $profile->profile_image_url }}" class="profile-img">
                        <h3 class="mt-3">{{ $profile->name }}</h3>
                        <span class="badge bg-{{ $profile->status == 'active' ? 'success' : 'danger' }} fs-6">{{ ucfirst($profile->status) }}</span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-label"><i class="bi bi-envelope"></i> Email</div>
                            <p>{{ $profile->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label"><i class="bi bi-phone"></i> Phone</div>
                            <p>{{ $profile->phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="info-label"><i class="bi bi-geo-alt"></i> Address</div>
                            <p>{{ $profile->address ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label"><i class="bi bi-calendar"></i> Joined</div>
                            <p>{{ $profile->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label"><i class="bi bi-pencil"></i> Last Updated</div>
                            <p>{{ $profile->updated_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="/profiles/edit/{{ $profile->id }}" class="btn btn-warning">Edit Profile</a>
                        <a href="/profiles" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>