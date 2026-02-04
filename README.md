# PHP_Laravel12_With_SQLite



## Description:

PHP_Laravel12_With_SQLite is a beginner-friendly Laravel 12 CRUD project using SQLite as the database. This project demonstrates how to perform Create, Read, Update, and Delete (CRUD) operations on a profiles table with basic fields like Name and Email, following Laravel’s MVC architecture.

It is designed for lightweight, file-based storage with no need for MySQL or other external database servers, making it easy to run locally for testing, learning, or small projects.



## Key Features:

Uses Laravel 12 framework.

SQLite database for lightweight and file-based storage.

CRUD operations on a profiles table (Name & Email).

Blade templates for front-end views.

Bootstrap 5 for responsive design.

Routes defined in web.php for all operations.

Easy to run locally using php artisan serve.

Works without needing MySQL or external database servers.



## Technology Stack

Backend: PHP 8+ with Laravel 12

Database: SQLite

Frontend: Blade Templates + Bootstrap 5


---



# Project SetUp

---



## STEP 1: Create New Laravel 12 Project

### Run Command :

```
composer create-project laravel/laravel PHP_Laravel12_With_SQLite "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_With_SQLite

```

Make sure Laravel 12 is installed successfully.




## STEP 2: Now Project Folder Structure

```
PHP_Laravel12_With_SQLite/
│── app/
│── bootstrap/
│── config/
│── database/
│   ├── migrations/
│   ├── seeders/
│   └── database.sqlite   ❌ (create now)
│── public/
│── resources/
│   └── views/
│── routes/
│── .env
│── artisan

```


## STEP 3: Create SQLite Database File

### Manually create file:

```
database/database.sqlite

```

 Must be empty file, no extension



## STEP 4: Configure .env for SQLite

### Open .env and replace DB section

```
DB_CONNECTION=SQLite

DB_DATABASE=database/database.sqlite

```

❌ Remove / ignore MySQL lines



## STEP 5: Verify SQLite Config (No Change Needed)

### config/database.php:

```
'sqlite' => [
    'driver' => 'sqlite',
    'database' => env('DB_DATABASE', database_path('database.sqlite')),
    'prefix' => '',
    'foreign_key_constraints' => true,
],

```

## STEP 6: Clear Cache

### Run:

```
php artisan config:clear

php artisan cache:clear

```

## STEP 7: Run Default Migrations

### Run:

```
php artisan migrate

```

✔ Creates tables inside database.sqlite



# Install DB Browser for SQLite

### STEP 8.1: Install DB Browser for SQLite

1. Go to DB Browser for SQLite official site

2. Download the Windows installer (or your OS version).

3. Install → Next → Next → Finish.



## STEP 8.2: Open SQLite Database File

1. Open DB Browser for SQLite

2. Click Open Database

3. Go to your project folder:

```
PHP_Laravel12_With_SQLite/database/

```

4. Select database.sqlite and click Open.


## STEP 8.3: View Tables

1. Click the Browse Data tab.

2. Select a table from the dropdown (e.g., profiles, users, migrations).

3. You can now see your database rows and columns.

This is just for viewing. You don’t need it to run your project.



## STEP 9: Create Profile Model + Migration

### Run:

```
php artisan make:model Profile -m

```

## STEP 10: Migration & Model Code

### database/migrations/xxxx_create_profiles_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};

```

### app/Models/Profile.php

```

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];
}

```


## STEP 11: Create Controller

### Run:

```
php artisan make:controller ProfileController

```

### app/Http/Controllers/ProfileController.php

```
<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        Profile::create($request->all());

        return redirect('/profiles')->with('success', 'Profile added successfully');
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->update($request->all());

        return redirect('/profiles')->with('success', 'Profile updated successfully');
    }

    public function destroy($id)
    {
        Profile::destroy($id);
        return redirect('/profiles')->with('success', 'Profile deleted successfully');
    }
}

```


## STEP 12: Routes

### routes/web.php:

```

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/profiles/create', [ProfileController::class, 'create']);
Route::post('/profiles/store', [ProfileController::class, 'store']);
Route::get('/profiles/edit/{id}', [ProfileController::class, 'edit']);
Route::post('/profiles/update/{id}', [ProfileController::class, 'update']);
Route::get('/profiles/delete/{id}', [ProfileController::class, 'destroy']);

```


## STEP 13: Create Blade Views

### Create folder:

```
resources/views/profiles/

```

### resources/views/profiles/create.blade.php

```

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

```

### resources/views/profiles/index.blade.php

```

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

```


### resources/views/profiles/edit.blade.php

```

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

```


## STEP 14: Run Project

### Run:

```
php artisan serve

```

### Open browser:

```
http://127.0.0.1:8000/profiles

```


## So you can see this type output:


### Profile page:


<img width="1919" height="961" alt="Screenshot 2026-02-03 164210" src="https://github.com/user-attachments/assets/b61c1413-def5-4786-9003-1e1ee270756b" />


### Add Profile Page:


<img width="1919" height="955" alt="Screenshot 2026-02-03 164236" src="https://github.com/user-attachments/assets/3565529c-d068-4010-aa3e-bf5dd555db09" />

after add show success message:

<img width="1919" height="947" alt="Screenshot 2026-02-03 164246" src="https://github.com/user-attachments/assets/c1fd8338-3906-458d-9e45-d74380e73841" />



### Edit Profile Page:


<img width="1919" height="942" alt="Screenshot 2026-02-03 164300" src="https://github.com/user-attachments/assets/8730f1d9-803e-42f6-9a62-4d01820cd12e" />

after edit show success message:

<img width="1916" height="954" alt="Screenshot 2026-02-03 164312" src="https://github.com/user-attachments/assets/9cc072d4-0619-44e7-ad04-6426e306de89" />


### Delete Profile Page:


<img width="1919" height="942" alt="image" src="https://github.com/user-attachments/assets/309ae3c2-d1c9-4727-966a-06a8ca97d254" />


---


# Project Folder Structure:

```


PHP_Laravel12_With_SQLite/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ProfileController.php       # ✔ Your controller
│   ├── Models/
│   │   └── Profile.php                      # ✔ Your model
│   └── ...                                  # Default Laravel folders/files
│
├── bootstrap/
│   └── app.php
│
├── config/
│   ├── app.php
│   ├── database.php                         # ✔ Has SQLite config
│   └── ...
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_profiles_table.php   # ✔ Your migration
│   │   └── ...                              # Default Laravel migrations
│   ├── seeders/
│   │   └── DatabaseSeeder.php
│   └── database.sqlite                       # ✔ SQLite DB file
│
├── public/
│   ├── index.php
│   └── ...
│
├── resources/
│   └── views/
│       ├── welcome.blade.php
│       └── profiles/
│           ├── create.blade.php            # ✔
│           ├── edit.blade.php              # ✔
│           └── index.blade.php             # ✔
│
├── routes/
│   └── web.php                              # ✔ CRUD routes
│
├── storage/
│   └── ...
│
├── tests/
│   └── ...
│
├── vendor/
│   └── ...
│
├── .env                                     # ✔ Configured for SQLite
├── artisan                                  # ✔
├── composer.json
├── composer.lock
├── phpunit.xml
└── README.md                                # ✔ Your README

```
