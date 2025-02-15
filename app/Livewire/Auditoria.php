<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Livewire\WithPagination;
use Illuminate\View\View;
use League\Csv\Writer;
use SplTempFileObject;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[\Livewire\Attributes\Layout('layouts.app')]
class Auditoria extends Component
{
    use WithPagination;

    public $perPage = 10;

    public function exportXlsx(): StreamedResponse
    {
        $logs = Activity::with('causer', 'subject')
            ->orderBy('created_at', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Data');
        $sheet->setCellValue('B1', 'Usuário');
        $sheet->setCellValue('C1', 'Ação');
        $sheet->setCellValue('D1', 'Entidade');
        $sheet->setCellValue('E1', 'Nome');

        $row = 2;
        foreach ($logs as $log) {
            $nome = match($log->event) {
                'deleted' => $log->properties['old']['nome'] ?? $log->properties['old']['name'] ?? 'N/A',
                'created' => $log->properties['attributes']['nome'] ?? $log->properties['attributes']['name'] ?? 'N/A',
                'updated' => ($log->properties['old']['nome'] ?? $log->properties['old']['name'] ?? 'N/A') . ' → ' .
                           ($log->properties['new']['nome'] ?? $log->properties['new']['name'] ?? 'N/A'),
                default => $log->subject->nome ?? $log->subject->name ?? 'N/A'
            };

            $sheet->setCellValue('A' . $row, $log->created_at->format('d/m/Y H:i:s'));
            $sheet->setCellValue('B' . $row, $log->causer->name);
            $sheet->setCellValue('C' . $row, $log->description);
            $sheet->setCellValue('D' . $row, class_basename($log->subject_type));
            $sheet->setCellValue('E' . $row, $nome);

            $row++;
        }

        // Colunas auto size
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, 'auditoria.xlsx');
    }

    public function exportCsv(): StreamedResponse
    {
        $logs = Activity::with('causer', 'subject')
            ->orderBy('created_at', 'desc')
            ->get();

        $csv = Writer::createFromFileObject(new SplTempFileObject());
        
        // Headers
        $csv->insertOne([
            'Data',
            'Usuário',
            'Ação',
            'Entidade',
            'Nome'
        ]);

        // Adiciona dados
        foreach ($logs as $log) {
            $nome = match($log->event) {
                'deleted' => $log->properties['old']['nome'] ?? $log->properties['old']['name'] ?? 'N/A',
                'created' => $log->properties['attributes']['nome'] ?? $log->properties['attributes']['name'] ?? 'N/A',
                'updated' => ($log->properties['old']['nome'] ?? $log->properties['old']['name'] ?? 'N/A') . ' → ' .
                           ($log->properties['new']['nome'] ?? $log->properties['new']['name'] ?? 'N/A'),
                default => $log->subject->nome ?? $log->subject->name ?? 'N/A'
            };

            $csv->insertOne([
                $log->created_at->format('d/m/Y H:i:s'),
                $log->causer->name,
                $log->description,
                class_basename($log->subject_type),
                $nome
            ]);
        }

        return response()->streamDownload(function() use ($csv) {
            echo $csv->toString();
        }, 'auditoria.csv');
    }

    public function render(): View
    {
        $logs = Activity::with('causer', 'subject')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.auditoria', [
            'logs' => $logs,
            'paginationEnabled' => true
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
