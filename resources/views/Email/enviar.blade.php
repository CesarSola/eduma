<x-mail::message>
    @component('mail::message')
    # {{ $mailData['titulo'] }}

    contenido del correo...

    @component('mail::button', ['url' => $mailData['url'], 'color' => 'success'])
    Boton
    @endcomponent

    Saludos,<br>
    {{ config('app.name') }}
    @endcomponent
</x-mail::message>
