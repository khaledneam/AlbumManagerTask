<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Picture extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'album_id','file_path'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }


    public function deleteFile()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            Storage::disk('public')->delete($this->file_path);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($picture) {
            $picture->deleteFile();
        });
    }


}
