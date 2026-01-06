<?php

namespace App\Livewire\Admin\ClienteAntiguo;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class ClienteAntiguoEditarLivewire extends Component
{
    public function render()
    {
        return view('livewire.admin.cliente-antiguo.cliente-antiguo-editar-livewire');
    }
}
