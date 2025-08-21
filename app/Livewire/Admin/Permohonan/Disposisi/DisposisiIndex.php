<?php

namespace App\Livewire\Admin\Permohonan\Disposisi;

use App\Models\Disposisi;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Disposisi')]
class DisposisiIndex extends Component
{
    public function render()
    {
        $disposisis = Disposisi::orderBy('created_at', 'desc')->get();
        return view('livewire.admin.permohonan.disposisi.disposisi-index', [
            'disposisis' => $disposisis
        ]);
    }
}
