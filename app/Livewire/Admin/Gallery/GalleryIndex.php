<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Galeri')]
class GalleryIndex extends Component
{
    public function deleteGallery($id)
    {
        if (!in_array(Auth::user()->role, ['superadmin', 'supervisor'])) {
            abort(403);
        }

        $gallery = Gallery::find($id);
        if ($gallery) {
            Storage::disk('public')->delete($gallery->images);
            $gallery->delete();
        }
    }

    #[On('refresh-gallery')]
    public function render()
    {
        $galleries = Gallery::all();
        return view('livewire.admin.gallery.gallery-index', compact('galleries'));
    }
}
