<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 pb-1 pt-0 sm:p-6 lg:p-8 lg:pb-1">
        
        <div class="text-right mb-2 mt-3">
            <form method="POST" action="{{ route('profile.pounds') }}">
                @csrf

                <label class="inline-flex items-center cursor-pointer">
                    <span class="ms-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">KG</span>

                    <input 
                        type="checkbox" 
                        name="lbs"
                        value="1" 
                        class="sr-only peer"
                        onchange="this.form.submit()"
                        @php if(Auth::user()->lbs) echo 'checked'; @endphp
                    >

                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">LBS</span>
                </label>
            </form>
        </div>
  

        <fieldset class="border border-gray-200 rounded-md shadow-sm p-4 bg-white">
            <legend class="text-lg font-medium text-gray-900">
                {{ __('Add Weight') }}
            </legend>

            <form method="POST" action="{{ route('weights.store') }}">
                @csrf

                <div class="mb-2">
                    <label for="date" class="block text-md font-bold text-gray-700">
                        {{ __('Date') }}
                    </label>
                    <input
                        type="date"
                        title="{{ __('Select date for weight in') }}"
                        name="date"
                        value="{{ old('date', date('Y-m-d')) }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                </div>

                <div class="mb-2">
                    <label for="weight" class="block text-md font-bold text-gray-700">
                        {{ __('Weight') }}
                    </label>
                    <input
                        type="text"
                        title="{{ __('Enter your weight for the selected date') }}"
                        name="weight"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
                    <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                </div>    

                <div>
                    <x-primary-button class="mt-2">{{ __('Add Weight') }}</x-primary-button>
                </div>
            </form>
        </fieldset>
    </div>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 pt-0 pb-0">
       <fieldset class="border border-gray-200 rounded-md shadow-sm p-4 pt-0 bg-white">
            <legend class="text-lg font-medium text-gray-900">
                {{ __('Weights') }}
            </legend>
        
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Date') }}
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Weight') }}
                        </th>
                        <th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($weights as $index =>$weight)
                        <tr<?php if ($index % 2 === 0) echo ' class="bg-gray-50"'; ?>>
                            <td class="px-4 py-2 text-gray-500 whitespace-nowrap">
                                {{ $weight->date }}
                            </td>
                            <td class="px-4 py-2 text-gray-500 whitespace-nowrap">
                                {{ $weight->weight }}
                            </td>
                            <td>
                                @if ($weight->user->is(auth()->user()))
                                <form method="POST" action="{{ route('weights.destroy', $weight) }}">
                                    @csrf
                                    @method('delete')

                                    <a
                                        href="{{ route('weights.destroy', $weight) }}" class="text-red-500 hover:text-red-800"
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
                {{ $weights->onEachSide(5)->links() }}
            </div>
       </fieldset>
    </div>
</x-app-layout>

<script>
    function submitDelete(event, self) {
        event.preventDefault();

        if(confirm('Are you sure you want to delete this weight?')) {
            self.closest('form').submit();
        }
    }
</script>