<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Histórico de Auditoria
            </h2>
        </div>
    </header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded shadow-lg p-6">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Usuário
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ação
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Entidade
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($logs as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->causer->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ class_basename($log->subject_type) }} - 
                                @if($log->event === 'deleted' && isset($log->properties['old']))
                                    {{ $log->properties['old']['nome'] ?? $log->properties['old']['name'] ?? 'N/A' }}
                                @elseif($log->event === 'created' && isset($log->properties['attributes']))
                                    {{ $log->properties['attributes']['nome'] ?? $log->properties['attributes']['name'] ?? 'N/A' }}
                                @elseif($log->event === 'updated' && isset($log->properties['old']) && isset($log->properties['new']))
                                    {{ $log->properties['old']['nome'] ?? $log->properties['old']['name'] ?? 'N/A' }} → 
                                    {{ $log->properties['new']['nome'] ?? $log->properties['new']['name'] ?? 'N/A' }}
                                @elseif($log->subject)
                                    {{ $log->subject->nome ?? $log->subject->name ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
