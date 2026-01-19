<?php

namespace App\Livewire\Guest;

use App\Models\Gallery;
use Livewire\Component;

class GalleryGuest extends Component
{
    public function render()
    {
        $galleries = Gallery::latest()->take(6)->get();
        return view('livewire.guest.gallery-guest', compact('galleries'));
    }
}
