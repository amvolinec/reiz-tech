<?php

namespace App\Services;

use App\Http\Requests\JobCreateRequest;
use App\Jobs\ScrapeJob;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class JobService
{
    public function createJob(JobCreateRequest $request): string
    {
        $data = $request->validated();

        $jobId = Str::uuid()->toString();
        $jobData = [
            'id' => $jobId,
            'urls' => $data['urls'],
            'selectors' => $data['selectors'],
            'status' => 'pending',
            'result' => null,
        ];

        Redis::set("job:{$jobId}", json_encode($jobData));

        ScrapeJob::dispatch($jobData);

        return $jobId;
    }

    public function getJobById($id)
    {
        return Redis::get("job:{$id}");
    }

    public function deleteJob($id): void
    {
        Redis::del("job:{$id}");
    }
}
