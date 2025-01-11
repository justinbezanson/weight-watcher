<x-app-layout>
    {!! $chart->renderHtml() !!}
</x-app-layout>

{!! $chart->renderChartJsLibrary() !!}
{!! $chart->renderJs() !!}