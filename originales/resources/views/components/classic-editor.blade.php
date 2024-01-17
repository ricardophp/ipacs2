<div class="border-b" wire:ignore x-data="{
    message: @entangle($attributes->wire('model'))
}" x-init="
    ClassicEditor
    .create( $refs.myEditor,{
        language: 'en'
    })
    .then( editor => {
        editor.model.document.on('change:data', () => {
            message = editor.getData();
        });
    })
    .catch( error => {
        console.error(error);
    });
">
    <div x-ref="myEditor"></div>
</div>
