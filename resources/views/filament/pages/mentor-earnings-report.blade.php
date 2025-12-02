<x-filament-panels::page>
    <div class="mb-6 text-gray-600">
        Laporan pendapatan hanya mencakup kursus yang Anda buat.
        {{-- Hanya transaksi dengan status <strong>settlement</strong> dan <strong>fraud_status = accept</strong> yang dihitung. --}}
    </div>

    {{ $this->table }}
</x-filament-panels::page>
