<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCreateRequest;
use App\Services\JobService;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

class JobController extends Controller
{
    const MALFORMED_UUID = 'Malformed uuid';
    const JOB_NOT_FOUND = 'Job not found';
    const JOB_DELETED = 'Job deleted';

    public function __construct(
        private readonly JobService $service
    ) {
    }

    public function create(JobCreateRequest $request): JsonResponse
    {
        $jobId = $this->service->createJob($request);

        return response()->json(['job_id' => $jobId], 201);
    }

    public function show(string $uuid): JsonResponse
    {
        $isValidUuid = Uuid::isValid($uuid);

        if (!$isValidUuid) {
            return response()->json(['error' => self::MALFORMED_UUID], 422);
        }

        $jobData = $this->service->getJobById($uuid);

        if (!$jobData) {
            return response()->json(['error' => self::JOB_NOT_FOUND], 404);
        }

        return response()->json(json_decode($jobData, true));
    }

    public function destroy($uuid): JsonResponse
    {
        $isValidUuid = Uuid::isValid($uuid);

        if (!$isValidUuid) {
            return response()->json(['error' => self::MALFORMED_UUID], 422);
        }

        $jobData = $this->service->getJobById($uuid);

        if (!$jobData) {
            return response()->json(['error' => self::JOB_NOT_FOUND], 404);
        }

        $this->service->deleteJob($uuid);

        return response()->json(['message' => self::JOB_DELETED], 200);
    }

    public function healthCheck(): JsonResponse
    {
        return response()->json(['status' => 'success', 'message' => 'Token is valid']);
    }
}
