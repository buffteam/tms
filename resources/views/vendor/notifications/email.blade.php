@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
    # {{ $greeting }}
@else
    @if ($level == 'error')
        # Whoops!
    @else
        # 您好!
    @endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
    {{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
switch ($level) {
    case 'success':
        $color = 'green';
        break;
    case 'error':
        $color = 'red';
        break;
    default:
        $color = 'blue';
}
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
    {{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
    {{ $salutation }}
@else
    最真挚的问候,{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
如果您点击这个 "{{ $actionText }}" 按钮有问题, 请复制下面的地址到现代浏览器中打开即可。
复制地址: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
