<x-layout>
    <div class="space-y-10">
        {{-- Section for Find your job --}}
        <section class="text-center pt-6">
            <h1 class="font-bold text-4xl">Let's Find Your Job</h1>

            <x-forms.form action="{{ url('/search') }}" class="mt-6">
                <x-forms.input :label="false" name="q" placeholder="Web Developer..."/>
            </x-forms.form>
        </section>

        {{-- Section for Featured Jobs --}}
        <section class="pt-10">
            <x-section-heading>Featured jobs</x-section-heading>

            <div class="grid lg:grid-cols-3 gap-8 mt-6">
                @foreach ($featuredJobs as $job)
                    <x-job-card :$job/>
                @endforeach
            </div>
        </section>

        {{-- Section for tags --}}
        <section>
            <x-section-heading>Tags</x-section-heading>

            <div class="mt-6 space-x-3">
                @foreach ($tags as $tag)
                    <x-tag :$tag />
                    {{-- <x-tag>$tag->name</x-tag> --}}
                @endforeach
            </div>
        </section>

        {{-- Section for Recent Jobs --}}
        {{-- <section>
            <x-section-heading>Recent Jobs</x-section-heading>

            <div class="mt-6 space-y-6">
                @foreach ($jobs as $job)
                    <x-job-card-wide :$job/>
                @endforeach
        
            </div>
        </section> --}}

        {{-- Section for Recent Jobs --}}
        <section>
            <x-section-heading>Recent Jobs</x-section-heading>

            <x-data-table 
                :columns="[ 
                    ['label' => 'ID'],
                    ['label' => 'Title'],
                    ['label' => 'Salary'],
                    ['label' => 'Location'],
                    ['label' => 'Company'],
                    ['label' => 'Posted On'],
                    ['label' => 'Actions']
                ]"
                ajaxUrl="{{ route('jobs.data') }}" 
            />
        </section>

        @stack('scripts')
    </div>
</x-layout>