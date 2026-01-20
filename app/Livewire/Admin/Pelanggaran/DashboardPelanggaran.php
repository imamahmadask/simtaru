<?php

namespace App\Livewire\Admin\Pelanggaran;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Pelanggaran')]
class DashboardPelanggaran extends Component
{
    
    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        return view('livewire.admin.pelanggaran.dashboard-pelanggaran');
    }
}
