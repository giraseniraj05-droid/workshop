<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of services.
     */
    public function index()
    {
        $services = $this->serviceRepository->getAll();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created service in database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:255', 'unique:services,name_en'],
            'name_ar' => ['required', 'string', 'max:255', 'unique:services,name_ar'],
            'description_en' => ['required', 'string', 'max:2000'],
            'description_ar' => ['required', 'string', 'max:2000'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'icon' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        }

        $data['slug'] = Str::slug($data['name_en']);
        
        $this->serviceRepository->create($data);

        return redirect()->route('admin.services.index')
            ->with('success', __('messages.service_create_success'));
    }

    /**
     * Show the form for editing the service.
     */
    public function edit($id)
    {
        $service = $this->serviceRepository->find($id);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the service in database.
     */
    public function update(Request $request, $id)
    {
        $service = $this->serviceRepository->find($id);

        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:255', 'unique:services,name_en,' . $service->id . ',_id'],
            'name_ar' => ['required', 'string', 'max:255', 'unique:services,name_ar,' . $service->id . ',_id'],
            'description_en' => ['required', 'string', 'max:2000'],
            'description_ar' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'icon' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        }

        $data['slug'] = Str::slug($data['name_en']);

        $this->serviceRepository->update($id, $data);

        return redirect()->route('admin.services.index')
            ->with('success', __('messages.service_update_success'));
    }

    /**
     * Delete a service.
     */
    public function destroy($id)
    {
        $this->serviceRepository->delete($id);
        return redirect()->route('admin.services.index')
            ->with('success', __('messages.service_delete_success'));
    }
}
