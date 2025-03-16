<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ContactsExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    private int $chunkSize = 1000;

    protected $headers = ['Nom du contact', 'Email', 'Téléphone', 'Opportunity', 'Responsable', 'Étiquettes'];
    protected $columnMap = [];

    public function __construct(public readonly array $columns = []){}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Contact::with(['user:id,first_name', 'tags:id,name'])
            ->select(['id', 'user_id','first_name', 'last_name', 'email', 'phone', 'opportunity']);
    }

    public function headings(): array
    {
        if ($this->columns) {
            return array_map(fn($col) => $this->headers[$col] ?? $col, $this->columns);
        }

        return array_values($this->headers);
    }

    public function map($contact): array
    {
        $data = [
            "{$contact->first_name} {$contact->last_name}",
            $contact->email,
            $contact->phone,
            $contact->opportunity,
            optional($contact->user)->first_name,
            $contact->tags->pluck('name')->implode(', '),
        ];

        if ($this->columns) {
            return array_map(fn($col) => $data[$col] ?? $col, $this->columns);
        }

        return $data;
    }

    public function chunkSize(): int
    {
        return $this->chunkSize;
    }
}
