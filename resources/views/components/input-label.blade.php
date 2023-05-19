@props(['value', 'required' => false, 'opsional' => false])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-red-500">*</span>
    @elseif($opsional)
        <span class="text-gray-500">(opsional)</span>
    @endif
</label>
