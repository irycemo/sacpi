@props([
    'leadingAddOn' => false
])

<div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset">

    @if($leadingAddOn)

        <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm pr-2">
            {{ $leadingAddOn }}
        </span>

    @endif

    <input
        {{ $attributes }}
        class="{{ 'leadingAddOn' ? 'rounded-r-md' : '' }} bg-white text-sm w-full rounded-md p-2 border border-gray-500 outline-none ring-blue-600 focus:ring-1 focus:border-blue-600">

</div>
