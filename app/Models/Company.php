<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'website',
        'about',
        'linked_in',
        'user_id',
        'category_id'
    ];

    public function jobs() {
        return $this->hasMany(Job::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function resumes()
    {
        return $this->hasMany(CompanyResume::class);
    }
}
