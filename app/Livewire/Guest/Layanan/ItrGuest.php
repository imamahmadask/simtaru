<?php

namespace App\Livewire\Guest\Layanan;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('ITR')]
class ItrGuest extends Component
{
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.guest.layanan.itr-guest');
    }
}
