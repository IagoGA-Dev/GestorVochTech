<?php

namespace App\Livewire;

use Livewire\Component;

class DarkModeToggle extends Component
{
    public bool $darkMode = false;

    public function mount()
    {
        $this->darkMode = false;
    }

    public function toggleDarkMode()
    {
        $this->darkMode = !$this->darkMode;
        $this->dispatch('dark-mode-toggled');
    }

    public function render()
    {
        return view('livewire.dark-mode-toggle');
    }
}
