<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;

class HomeController extends Controller
{
    public function __construct(private readonly MenuRepository $menuRepository) {}

    public function index()
    {
        $featuredMenus = $this->menuRepository->getFeatured(6);
        $bestSellers = $this->menuRepository->getBestSellers(4);

        return view('customer.home', compact('featuredMenus', 'bestSellers'));
    }
}
