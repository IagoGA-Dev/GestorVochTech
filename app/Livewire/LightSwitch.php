<?php

namespace App\Livewire;

use Livewire\Component;

class LightSwitch extends Component
{
    public $isDarkMode;

    public function mount()
    {
        $this->isDarkMode = session()->get('dark-mode', false);
    }

    public function toggleDarkMode()
    {
        $this->isDarkMode = !$this->isDarkMode;
        session()->put('dark-mode', $this->isDarkMode);

        $this->dispatch('toggle-dark-mode', ['isDarkMode' => $this->isDarkMode]);
    }

    public function render()
    {
        return view('livewire.light-switch');
    }
}