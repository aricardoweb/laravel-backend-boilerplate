<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'url',
    ];

    public function fileSize(): ?int
    {
        if (! $this->path || ! Storage::disk('public')->exists($this->path)) {
            return null;
        }

        return Storage::disk('public')->size($this->path);
    }

    public function formattedFileSize(): string
    {
        $bytes = $this->fileSize();

        if ($bytes === null) {
            return '—';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $bytes > 0 ? min((int) floor(log($bytes, 1024)), count($units) - 1) : 0;
        $value = $bytes / (1024 ** $power);
        $decimals = $power === 0 || $value >= 10 ? 0 : 1;

        return number_format($value, $decimals, ',', '.').' '.$units[$power];
    }
}
