@extends('layouts.app')

@section('content')
    {{-- Regenerate Form --}}
    <form method="POST" action="{{ route('GenerateResume') }}"
        class="max-w-4xl mx-auto p-6 bg-white rounded-md shadow-md flex justify-end">
        @csrf
        {{-- If you want to send any data for regeneration, include hidden inputs or textarea --}}
        @foreach ($sections as $section => $content)
            <input type="hidden" name="sections[{{ $section }}]"
                value="{{ old('sections.' . $section, $regenerated_data[$section] ?? $content) }}">
        @endforeach

        <button type="submit" class="btn btn-primary px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 ">
            Download cv
        </button>
    </form>

    {{-- Save Form --}}
    <form method="POST" action="{{ route('cv.regenerate') }}"
        class="max-w-4xl mx-auto p-6 bg-white rounded-md shadow-md mb-4">
        @csrf

        <input type="hidden" name="action" value="generate">
        <div class="sm:col-span-2">
            <label for="prompt" class="block text-sm font-medium text-gray-900">prompt</label>
            <textarea name="prompt" id="prompt" rows="3"
                class="mt-2 block w-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2"></textarea>
            <p class="text-gray-600 text-sm mt-1">You can provide additional prompt here</p>
        </div>

        {{-- Include all your inputs for saving, e.g. --}}
        @foreach ($sections as $section => $content)
            <div class="mb-6">
                <label for="{{ $section }}" class="block text-sm font-medium text-gray-700 mb-1 capitalize">
                    {{ str_replace('_', ' ', ucfirst($section)) }}
                </label>
                <textarea name="sections[{{ $section }}]" id="{{ $section }}" rows="6"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('sections.' . $section, $regenerated_data[$section] ?? $content) }}</textarea>
            </div>
        @endforeach
        <button type="submit" class="btn btn-secondary px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Regenerate
        </button>

    </form>


@endsection