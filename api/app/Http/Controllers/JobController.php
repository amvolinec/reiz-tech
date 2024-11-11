<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCreateRequest;
use App\Services\JobService;

class JobController extends Controller
{
    public function __construct(
        private readonly JobService $service
    ) {}

    public function create(JobCreateRequest $request)
    {
        $jobId = $this->service->createJob($request);

        return response()->json(['job_id' => $jobId], 201);
    }

    public function show($id)
    {
        $jobData = $this->service->getJobById($id);

        if (! $jobData) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        return response()->json(json_decode($jobData, true));
    }

    public function destroy($id)
    {
        $jobData = $this->service->getJobById($id);

        if (! $jobData) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        $this->service->deleteJob($id);

        return response()->json(['message' => 'Job deleted'], 200);
    }
}
