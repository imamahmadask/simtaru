<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'modul',
        'default_path',
        'custom_path',
        'original_filename',
        'file_size',
        'mime_type',
        'available_variables',
        'description',
        'updated_by',
    ];

    protected $casts = [
        'available_variables' => 'array',
        'file_size' => 'integer',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Cek apakah template menggunakan file custom hasil upload admin.
     */
    public function isCustom(): bool
    {
        return !empty($this->custom_path) && Storage::disk('local')->exists($this->custom_path);
    }

    /**
     * Mendapatkan path absolut file template aktif di server.
     * Prioritas:
     * 1. File kustom hasil upload di storage private: storage/app/private/{custom_path}
     * 2. File default di storage private: storage/app/private/templates/defaults/{default_path}
     * 3. Fallback lama ke public: public/templates/{default_path}
     */
    public function getActiveFilePath(): string
    {
        if ($this->isCustom()) {
            return Storage::disk('local')->path($this->custom_path);
        }

        $defaultPrivate = Storage::disk('local')->path('templates/defaults/' . $this->default_path);
        if (file_exists($defaultPrivate)) {
            return $defaultPrivate;
        }

        $publicFallback = public_path('templates/' . $this->default_path);
        if (file_exists($publicFallback)) {
            return $publicFallback;
        }

        return $defaultPrivate;
    }

    /**
     * Reset template ke versi default (hapus custom upload jika ada).
     */
    public function resetToDefault(): void
    {
        if ($this->custom_path && Storage::disk('local')->exists($this->custom_path)) {
            Storage::disk('local')->delete($this->custom_path);
        }

        $this->update([
            'custom_path' => null,
            'original_filename' => null,
            'file_size' => null,
            'mime_type' => null,
            'updated_by' => auth()->id() ?? $this->updated_by,
        ]);
    }
}
