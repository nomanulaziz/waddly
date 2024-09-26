@props(['job'])

<x-panel class="flex flex-col text-center">
    <div class="flex justify-between items-center">
        <div class="self-start text-sm">{{ $job->employer->name }}</div>
        <div class="text-sm"> {{ format_date($job->created_at, 'F j') }} </div>
    </div>


    <div class="py-8">
        <h3 class="group-hover:text-blue-600 text-xl font-bold transition-colors duration-300"> 
            <a href="{{ $job->url }}" target="_blank">
                {{ $job->title }} 
            </a>
        </h3>
        <p class="text-sm mt-4">{{ $job->schedule }} - From {{ $job->salary }}</p>
    </div>
    <div class="flex justify-between items-center mt-auto">
        <div class="space-x-1">
            @foreach ($job->tags as $tag)
                <x-tag :$tag size="small" />                
            @endforeach
        </div>

        <x-employer-logo :width="42" :employer="$job->employer" />
    </div>
</x-panel>