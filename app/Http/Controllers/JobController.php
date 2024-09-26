<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Models\Job;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // for separating featured and non-featured collections
        $jobs = Job::latest()->with(['employer', 'tags'])->get()->groupBy('featured');

        return view('jobs.index',[
            'jobs' => $jobs[0],
            'featuredJobs' => $jobs[1],
            'tags' => Tag::all()
        ]);

        // return view('jobs.index');
    }

    // Datatables function 
    public function getJobs()
    {
        $jobs = Job::with('employer')
                ->select('id', 'employer_id', 'title', 'salary', 'location', 'created_at')
                ->latest()
                ->get()
                ->map(function($job) {
                    return [
                        'id' => $job->id,
                        'title' => $job->title,
                        'salary' => $job->salary,
                        'location' => $job->location,
                        'created_at' => Carbon::parse($job->created_at)->format('d-m-Y'),
                        'company' => $job->employer ? $job->employer->name : 'N/A',
                    ];
                });

        return Datatables::of($jobs)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        // dd($request->all());

        $attributes  = $request->validated();

        // if the request has feature store it as a boolean
        $attributes['featured'] = $request->has('featured');

        // Get the current authenticated user who is employer
        // create a new job for this employer
        // empoyer id will automatically be set in the process
        // except tags create a job
        $job = Auth::user()->employer->jobs()->create(Arr::except($attributes, 'tags'));

        // Do we have any tags if not assume false
        if($attributes['tags'] ?? false) {
            foreach (explode(',', $attributes['tags']) as $tag) {
                $job->tag($tag);
            }
        }

        return redirect('/');
    }

    // Function to get job data for editing
    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return response()->json($job);
    }

    // Function to update the job
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $job->title = $request->input('job-title');
        $job->salary = $request->input('job-salary');
        $job->location = $request->input('job-location');
        $job->save();

        return response()->json(['success' => true]);
    }

    // Function to delete the job
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return response()->json(['success' => true]);
    }
}
