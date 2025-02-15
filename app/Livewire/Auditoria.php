<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Livewire\WithPagination;
use Illuminate\View\View;

#[\Livewire\Attributes\Layout('layouts.app')]
class Auditoria extends Component
{
    use WithPagination;

    public function render()
    {
        $logs = Activity::with('causer', 'subject')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.auditoria', ['logs' => $logs]);
    }
}
