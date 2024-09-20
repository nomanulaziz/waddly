<?php

namespace Tests\Unit;

use App\Models\Employer;
use App\Models\Job;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase; // Add if you're using factories

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_job_belongs_to_employer(): void
    {
        // 3 Step Process AAA
        
        // Arrange - Create the word in order to run your test
        $employer = Employer::factory()->create();
        $job = Job::factory()->create([
            'employer_id' => $employer->id,
        ]);

        // Act - Perform some kind of action
        $this->assertTrue($job->employer->is($employer));

        // Assert - What did you expect as a result of assertion
    }

    public function test_job_can_have_tags(): void
    {
        $job = Job::factory()->create();
        $job->tag('Frontend');

        $this->assertCount(1, $job->tags); // Check if the number of tags is 1
    }
}
