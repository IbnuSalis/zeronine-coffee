<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\LoyaltyService;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    public function __construct(private readonly LoyaltyService $loyaltyService) {}

    public function index()
    {
        $summary = $this->loyaltyService->getSummary(auth()->user());
        return view('customer.loyalty.index', compact('summary'));
    }
}
