@props(['placeholder'])
<div class="mb-4 sm:mb-6 relative">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
    <input type="text" id="searchBox" placeholder=" {{ $placeholder }}"
        class="w-full pl-10 pr-4 py-2 text-sm sm:text-base rounded-md border border-gray-300 focus:ring focus:ring-gray-300 focus:border-gray-300">
</div>
