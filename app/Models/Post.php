<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $table = 'posts';

    protected $primaryKey = 'id';

    // protected $fillable = [
    //     'title',
    //     'content',
    //     'user_id',
    //     'slug',
    // ];

        protected $fillable = [
        'title',
        'content',
    ];

    protected $casts = [
        'content' => 'string',
        'user_id' => 'integer',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


}
