<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 pb-0 pt-0 sm:p-6 lg:p-8 lg:pb-0">
        
        <div class="text-right mb-2 mt-3">
            <form method="POST" action="{{ route('profile.pounds') }}">
                @csrf

                <label class="inline-flex items-center cursor-pointer">
                    <span class="ms-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-400">KG/CM</span>

                    <input 
                        type="checkbox" 
                        name="lbs"
                        value="1" 
                        class="sr-only peer"
                        onchange="this.form.submit()"
                        @php if(Auth::user()->lbs) echo 'checked'; @endphp
                    >

                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-400">LBS/IN</span>
                </label>
            </form>
        </div>
  

        <fieldset class="border border-gray-200 rounded-md shadow-sm p-4 pt-0 bg-white">
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
                        {{ __('Weight') . ' (' . Auth::user()->getUnitOfMeasure() . ')' }}
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
                    <x-primary-button class="mt-2">{{ __('Check-In') }}</x-primary-button>
                </div>
            </form>
        </fieldset>

        <div class="text-right mb-0 mt-3">
            <a class="text-blue-500" href="{{ route('measurements.index') }}">{{ __('Track Other Measurements') }}</a> |
            <a class="text-blue-500" href="{{ route('weights.chart') }}">{{ __('See Chart') }}</a>
        </div>
    </div>
</x-app-layout>