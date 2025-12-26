<?php

namespace App\Livewire\Admin\Cliente;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class ClienteEditarLivewire extends Component
{
    public function render()
    {
        return view('livewire.admin.cliente.cliente-editar-livewire');
    }
}
