@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-gray-400 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
