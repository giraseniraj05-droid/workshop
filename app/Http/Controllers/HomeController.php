<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;

class HomeController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display the public homepage.
     */
    public function index()
    {
        $services = $this->serviceRepository->getActive();
        return view('welcome', compact('services'));
    }
}
