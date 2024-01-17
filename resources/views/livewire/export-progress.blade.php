<div>
    <button wire:click="export">Exportar</button>

    <div x-data="{ progress: @entangle('progress') }" x-init="() => { Livewire.on('updateProgress', (data) => progress = data.progress) }">
        <div class="bg-gray-200 w-full h-4 mb-4">
            <div class="bg-blue-500 h-full" x-bind:style="'width:' + progress + '%'"></div>
        </div>
        <p x-show="progress === 100">¡Exportación completa!</p>
    </div>
</div>

