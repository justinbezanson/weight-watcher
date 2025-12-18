<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 pb-0 pt-0 sm:p-6 lg:p-8 lg:pb-0">
        
        <div class="mb-2 mt-3">
            <fieldset class="border border-gray-200 rounded-md shadow-sm p-4 pt-0 bg-white">
                <legend class="text-lg font-medium text-gray-900">
                    {{ __('Filters') }}
                </legend>

                <form id="filter_form" method="GET" action="{{ route('weights.chart') }}" style="display:inline;">
                    <span>
                        <select
                            name="type"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            onchange="this.form.submit()"
                        >
                            <option value="Weight" @if(request()->get('type') == 'Weight') selected @endif>{{ __('Weight') }}</option>
                            @foreach ($types as $option)
                                <option value="{{ $option->name }}" @if(request()->get('type') == $option->name) selected @endif>{{ $option->name }}</option>                                
                            @endforeach
                        </select>
                    </span>
                    <span>
                        <select name="filter_range" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="7d">{{ __('Last 7 Days') }}</option>
                            <option value="1m">{{ __('Last 1 Month') }}</option>
                            <option value="3m">{{ __('Last 3 Months') }}</option>
                            <option value="6m">{{ __('Last 6 Months') }}</option>
                            <option value="1y">{{ __('Last 1 Year') }}</option>
                            <option value="3y">{{ __('Last 3 Years') }}</option>
                            <option value="5y">{{ __('Last 5 Years') }}</option>
                            <option value="all">{{ __('Show All Weights') }}</option>
                        </select>
                    </span>
                </form>

                <form method="POST" action="{{ route('profile.pounds') }}" style="display:inline;">
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

                        <input type="hidden" name="referrer" value="chart">

                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">LBS</span>
                    </label>
                </form>
            </fieldset>
        </div>
    </div>

    {!! $chart->renderHtml() !!}
</x-app-layout>

{!! $chart->renderChartJsLibrary() !!}
{!! $chart->renderJs() !!}

<script type="text/javascript">
    let form = document.querySelector('form#filter_form');
    let filterRange = document.querySelector('select[name="filter_range"]');

    filterRange.value = '{{ $filter_range }}';

    filterRange.addEventListener('change', function() {
        form.submit();
    });
</script>