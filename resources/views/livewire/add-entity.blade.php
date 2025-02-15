<div>
    <form wire:submit="createEntity" class="space-y-6">
        @if($entityName === 'colaborador')
            <div>
                <x-input-label for="nome" value="Nome" />
                <x-text-input id="nome" type="text" wire:model="form.nome" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('form.nome')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" type="email" wire:model="form.email" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="cpf" value="CPF" />
                <x-text-input id="cpf" type="text" wire:model="form.cpf" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('form.cpf')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="unidade" value="Unidade" />
                <select id="unidade" wire:model="form.unidade_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                    <option value="">Selecione uma unidade</option>
                    @foreach($unidades as $unidade)
                        <option value="{{ $unidade->id }}">{{ $unidade->nome_fantasia }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('form.unidade_id')" class="mt-2" />
            </div>

        @elseif($entityName === 'unidade')
            <div>
                <x-input-label for="nome_fantasia" value="Nome Fantasia" />
                <x-text-input id="nome_fantasia" type="text" wire:model="form.nome_fantasia" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('form.nome_fantasia')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="razao_social" value="Razão Social" />
                <x-text-input id="razao_social" type="text" wire:model="form.razao_social" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('form.razao_social')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="cnpj" value="CNPJ" />
                <x-text-input id="cnpj" type="text" wire:model="form.cnpj" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('form.cnpj')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="bandeira" value="Bandeira" />
                <select id="bandeira" wire:model="form.bandeira_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                    <option value="">Selecione uma bandeira</option>
                    @foreach($bandeiras as $bandeira)
                        <option value="{{ $bandeira->id }}">{{ $bandeira->nome }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('form.bandeira_id')" class="mt-2" />
            </div>

        @elseif($entityName === 'bandeira')
            <div>
                <x-input-label for="nome" value="Nome" />
                <x-text-input id="nome" type="text" wire:model="form.nome" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('form.nome')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="grupo" value="Grupo Econômico" />
                <select id="grupo" wire:model="form.grupo_economico_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                    <option value="">Selecione um grupo</option>
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('form.grupo_economico_id')" class="mt-2" />
            </div>

        @elseif($entityName === 'grupo')
            <div>
                <x-input-label for="nome" value="Nome" />
                <x-text-input id="nome" type="text" wire:model="form.nome" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('form.nome')" class="mt-2" />
            </div>
        @endif

        <div class="flex justify-end gap-4 pt-4">
            <x-secondary-button type="button" @click="show = false">
                Cancelar
            </x-secondary-button>

            <x-primary-button type="submit">
                Confirmar
            </x-primary-button>
        </div>
    </form>
</div>
