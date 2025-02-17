<form 
    wire:submit="save" 
    class="space-y-4"
    x-on:close-modal.window="if ($event.detail.name === '{{ $modalName }}') $wire.resetForm()"
>
    @csrf
    
    @if($entityName === 'grupo')
        <div>
            <x-input-label for="nome" value="Nome do Grupo" />
            <x-text-input wire:model="form.nome" id="nome" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('form.nome')" class="mt-2" />
        </div>
    @endif

    @if($entityName === 'bandeira')
        <div>
            <x-input-label for="nome" value="Nome da Bandeira" />
            <x-text-input wire:model="form.nome" id="nome" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('form.nome')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="grupo_economico_id" value="Grupo Econômico" />
            <select wire:model="form.grupo_economico_id" id="grupo_economico_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="">Selecione um grupo</option>
                @foreach($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('form.grupo_economico_id')" class="mt-2" />
        </div>
    @endif

    @if($entityName === 'unidade')
        <div>
            <x-input-label for="nome_fantasia" value="Nome Fantasia" />
            <x-text-input wire:model="form.nome_fantasia" id="nome_fantasia" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('form.nome_fantasia')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="razao_social" value="Razão Social" />
            <x-text-input wire:model="form.razao_social" id="razao_social" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('form.razao_social')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="cnpj" value="CNPJ" />
            <x-text-input wire:model="form.cnpj" id="cnpj" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('form.cnpj')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="bandeira_id" value="Bandeira" />
            <select wire:model="form.bandeira_id" id="bandeira_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="">Selecione uma bandeira</option>
                @foreach($bandeiras as $bandeira)
                    <option value="{{ $bandeira->id }}">{{ $bandeira->nome }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('form.bandeira_id')" class="mt-2" />
        </div>
    @endif

    @if($entityName === 'colaborador')
        <div>
            <x-input-label for="nome" value="Nome" />
            <x-text-input wire:model="form.nome" id="nome" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('form.nome')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="E-mail" />
            <x-text-input wire:model="form.email" id="email" type="email" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="cpf" value="CPF" />
            <x-text-input wire:model="form.cpf" id="cpf" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('form.cpf')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="unidade_id" value="Unidade" />
            <select wire:model="form.unidade_id" id="unidade_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="">Selecione uma unidade</option>
                @foreach($unidades as $unidade)
                    <option value="{{ $unidade->id }}">{{ $unidade->nome_fantasia }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('form.unidade_id')" class="mt-2" />
        </div>
    @endif

    <div class="mt-4 flex justify-end gap-4">
        <x-secondary-button @click="show = false">
            Cancelar
        </x-secondary-button>

        <x-primary-button type="submit">
            Confirmar
        </x-primary-button>
    </div>
</form>
