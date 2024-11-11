<?php

namespace Tests\Unit;

use App\Services\JobService;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Tests\TestCase;

class JobServiceTest extends TestCase
{
    public function testGetJobByIdSuccessfully()
    {
        $jobId = Str::uuid()->toString();
        $jobData = [
            'id' => $jobId,
            'urls' => ['http://example.com'],
            'selectors' => ['.example'],
            'status' => 'pending',
            'result' => null,
        ];

        Redis::set("job:{$jobId}", json_encode($jobData));

        $jobService = new JobService;
        $retrievedJob = $jobService->getJobById($jobId);

        $this->assertNotNull($retrievedJob);
        $this->assertEquals($jobData, json_decode($retrievedJob, true));
    }

    public function testGetJobByIdNotFound()
    {
        $jobService = new JobService;
        $retrievedJob = $jobService->getJobById('non-existent-id');

        $this->assertNull($retrievedJob);
    }

    public function testDeleteJobSuccessfully()
    {
        $jobId = Str::uuid()->toString();
        $jobData = [
            'id' => $jobId,
            'urls' => ['http://example.com'],
            'selectors' => ['.example'],
            'status' => 'pending',
            'result' => null,
        ];

        Redis::set("job:{$jobId}", json_encode($jobData));

        $jobService = new JobService;
        $jobService->deleteJob($jobId);

        $this->assertNull(Redis::get("job:{$jobId}"));
    }

    public function testDeleteJobNotFound()
    {
        $jobService = new JobService;
        $jobService->deleteJob('non-existent-id');

        $this->assertTrue(true); // Ensure no exception is thrown
    }
}
