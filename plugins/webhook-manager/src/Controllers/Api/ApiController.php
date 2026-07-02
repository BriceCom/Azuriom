<?php

namespace Azuriom\Plugin\WebhookManager\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\WebhookManager\Services\WebhookManagerManager;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function __construct(protected WebhookManagerManager $manager)
    {
    }

    public function events(): JsonResponse
    {
        return response()->json($this->manager->events());
    }
}
