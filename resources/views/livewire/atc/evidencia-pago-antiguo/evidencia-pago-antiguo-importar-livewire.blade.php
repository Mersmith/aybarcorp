<div>
    @if ($errors->has('archivo'))
    <div class="alert alert-danger">
        {{ $errors->first('archivo') }}
    </div>
    @endif


    <form wire:submit.prevent="importar">
        <input type="file" wire:model="archivo">
        <button type="submit">Importar Excel</button>
    </form>

</div>