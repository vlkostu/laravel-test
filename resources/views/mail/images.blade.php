<h1 style="text-align: center; font-family: sans-serif;">Здравствуйте, {{ $user->name }}!</h1>
<h3 style="text-align: center; font-family: sans-serif;">Ваше фото обработано.</h3>
<br>
<ul style="text-align: center; font-family: sans-serif; list-style-type: none">
    @forelse($images as $image)
        <li>
            <b>width: {{ $image->width }}</b> - <a href="{{ env('APP_URL') . $image->url }}">{{ $image->url }}</a>
        </li>
    @empty
        <h1>Упс, похоже вы ошиблись с размерамы и мы не смогли ничего обработать :(</h1>
    @endforelse
</ul>
