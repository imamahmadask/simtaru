<?php

namespace App\Livewire\Guest\Layanan;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SKRK')]
class SkrkGuest extends Component
{
    #[Layout('layouts.guest-onepage')]
    public function render()
    {
        return view('livewire.guest.layanan.skrk-guest');
    }
}
