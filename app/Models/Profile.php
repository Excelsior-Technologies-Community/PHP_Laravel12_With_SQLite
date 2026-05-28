<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'address', 'profile_image', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    // Accessor for profile image URL
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image && file_exists(public_path('uploads/profiles/' . $this->profile_image))) {
            return asset('uploads/profiles/' . $this->profile_image);
        }
        return asset('default-avatar.png');
    }
}