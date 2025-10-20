@props(['disabled' => false])

<!-- Menghapus semua kelas 'dark:' untuk memaksa tampilan Light Mode -->
<input @disabled($disabled) {{ $attributes->merge([
    'class' => '
        border-gray-300 
        bg-white 
        text-gray-900 
        focus:border-indigo-600 
        focus:ring-indigo-600 
        rounded-xl 
        shadow-sm
        p-3 
        placeholder-gray-500
    '
]) }}>
