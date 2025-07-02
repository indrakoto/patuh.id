@props(['livewire'])

@php
    $document = $livewire->getRecord();
    $filePath = $document?->file_path;
@endphp

@if($filePath)
    <a href="{{ route('document.view', ['fileName' => basename($filePath)]) }}"
       class="text-primary-600 hover:text-primary-800 hover:underline"
       target="_blank">
        Lihat Dokumen
    </a>
@else
    <span class="text-gray-500">Tidak ada file</span>
@endif