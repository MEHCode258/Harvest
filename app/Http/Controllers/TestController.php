<?php
namespace App\Http\Controllers;

use App\Services\HarvestService;

class TestController extends Controller
{
    protected $harvestService;

    public function __construct(HarvestService $harvestService)
    {
        $this->harvestService = $harvestService;
    }

    public function testHarvest()
    {
        try {
            $response = $this->harvestService->get('projects');
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}