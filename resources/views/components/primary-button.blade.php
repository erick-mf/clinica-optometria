<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-primary hover:bg-teal-800 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out w-full sm:w-auto text-center flex items-center justify-center font-medium']) }}>
    {{ $slot }}
</button>
