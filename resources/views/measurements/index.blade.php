<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 pb-0 pt-0 sm:p-6 lg:p-8 lg:pb-0">  
        @if (session('success'))
            <div class="border border-green-400 rounded-md bg-green-100 p-4 mb-4 text-green-700 flex">
                <div class="flex-[3]">{{ session('success') }}</div>

                <div class="flex-[1] w-1/4 text-right cursor-pointer">
                    <a href="javascript:void(0);" onclick="event.target.parentElement.parentElement.remove();">
                        X
                    </a>
                </div>
            </div>
        @endif

        <fieldset class="border border-gray-200 rounded-md shadow-sm p-4 pt-0 bg-white">
            <legend class="text-lg font-medium text-gray-900">
                {{ __('Add Measurement Type') }}
            </legend>

            <form method="POST" action="{{ route('measurements.store') }}">
                @csrf

                <div class="mb-2">
                    <label for="name" class="block text-md font-bold text-gray-700">
                        {{ __('Name') }}
                    </label>
                    <input
                        type="text"
                        title="{{ __('Enter the name of the measurement you want to track') }}"
                        name="name"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>    

                <div>
                    <x-primary-button class="mt-2">{{ __('Add Measurement') }}</x-primary-button>
                </div>
            </form>
        </fieldset>
    </div>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 lg:pt-0 sm:pt-0 pt-0 pb-0">
       <fieldset class="border border-gray-200 rounded-md shadow-sm p-4 pt-0 bg-white">
            <legend class="text-lg font-medium text-gray-900">
                {{ __('Measurements') }}
            </legend>
        
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Name') }}
                        </th>
                        <th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($measurementTypes as $index => $type)
                        <tr<?php if ($index % 2 === 0) echo ' style="background-color: #e8f3ee;"'; ?>>
                            <td class="px-4 py-2 text-gray-500 whitespace-nowrap">
                                {{ $type->name }}
                            </td>
                            <td>
                                @if ($type->user->is(auth()->user()))
                                <form method="POST" action="{{ route('measurements.destroy', $type) }}">
                                    @csrf
                                    @method('delete')

                                    <a
                                        href="{{ route('measurements.destroy', $type) }}" class="text-red-500 hover:text-red-800"
                                        onclick="submitDelete(event, this)"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0,0,256,256">
                                        <g fill="#7d7d7d" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(8,8)"><path d="M15,4c-0.52344,0 -1.05859,0.18359 -1.4375,0.5625c-0.37891,0.37891 -0.5625,0.91406 -0.5625,1.4375v1h-6v2h1v16c0,1.64453 1.35547,3 3,3h12c1.64453,0 3,-1.35547 3,-3v-16h1v-2h-6v-1c0,-0.52344 -0.18359,-1.05859 -0.5625,-1.4375c-0.37891,-0.37891 -0.91406,-0.5625 -1.4375,-0.5625zM15,6h4v1h-4zM10,9h14v16c0,0.55469 -0.44531,1 -1,1h-12c-0.55469,0 -1,-0.44531 -1,-1zM12,12v11h2v-11zM16,12v11h2v-11zM20,12v11h2v-11z"></path></g></g>
                                        </svg>
                                    </@auth
                                        
                                    @endauth>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-2">
                {{ $measurementTypes->onEachSide(0)->links() }}
            </div>
       </fieldset>
    </div>
</x-app-layout>

<script>
    function submitDelete(event, self) {
        event.preventDefault();

        if(confirm('Are you sure you want to delete this measurement? All data associated with this measurement will also be deleted.')) {
            self.closest('form').submit();
        }
    }
</script>