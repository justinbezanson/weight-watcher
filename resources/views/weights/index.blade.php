<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
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

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
       <fieldset class="border border-gray-200 rounded-md shadow-sm p-4  pt-0 bg-white">
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