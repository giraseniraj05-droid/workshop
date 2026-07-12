<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkerProfile;
use App\Repositories\WorkerRepository;
use App\Repositories\ServiceRepository;
use App\Services\AssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\FeedbackRepository;

class WorkerController extends Controller
{
    protected $workerRepository;
    protected $serviceRepository;
    protected $assignmentService;
    protected $feedbackRepository;

    public function __construct(
        WorkerRepository $workerRepository,
        ServiceRepository $serviceRepository,
        AssignmentService $assignmentService,
        FeedbackRepository $feedbackRepository
    ) {
        $this->workerRepository = $workerRepository;
        $this->serviceRepository = $serviceRepository;
        $this->assignmentService = $assignmentService;
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * Display a listing of workers.
     */
    public function index()
    {
        $workers = $this->workerRepository->getAll();
        return view('admin.workers.index', compact('workers'));
    }

    /**
     * Show the form for creating a new worker.
     */
    public function create()
    {
        $services = $this->serviceRepository->getAll();
        return view('admin.workers.create', compact('services'));
    }

    /**
     * Store a newly created worker in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'bio' => ['required', 'string', 'max:2000'],
            'experience' => ['required', 'integer', 'min:0'],
            'skills' => ['required', 'string', 'max:1000'], // comma-separated
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'linkedin' => ['nullable', 'url'],
            'facebook' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'services' => ['nullable', 'array'],
        ]);

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Worker',
            'status' => 'active',
        ]);
        $user->assignRole('Worker');

        // Handle profile photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profiles', 'public');
        }

        // Process skills array
        $skillsArray = array_map('trim', explode(',', $request->skills));
        $skillsArray = array_filter($skillsArray);

        // Create profile
        WorkerProfile::create([
            'user_id' => $user->id,
            'photo' => $photoPath,
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
            'experience' => (int) $request->experience,
            'skills' => $skillsArray,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
        ]);

        // Assign services if any
        if (!empty($request->services)) {
            foreach ($request->services as $serviceId) {
                $this->assignmentService->assignWorker($user->id, $serviceId);
            }
        }

        return redirect()->route('admin.workers.index')
            ->with('success', __('messages.worker_create_success'));
    }

    /**
     * Show worker details, service assignments, and assignment history.
     */
    public function show($id)
    {
        $worker = $this->workerRepository->find($id);
        $profile = $worker->workerProfile ?? new WorkerProfile();
        $assignedServices = $this->workerRepository->getAssignedServices($id);
        $allServices = $this->serviceRepository->getAll();
        $history = $this->workerRepository->getAssignmentHistory($id);

        $reviews = $this->feedbackRepository->getForWorker($id);
        $averageRating = $reviews->avg('rating') ?: 0;
        $reviewsCount = $reviews->count();

        return view('admin.workers.show', compact('worker', 'profile', 'assignedServices', 'allServices', 'history', 'reviews', 'averageRating', 'reviewsCount'));
    }

    /**
     * Show edit form for worker.
     */
    public function edit($id)
    {
        $worker = $this->workerRepository->find($id);
        $profile = $worker->workerProfile ?? new WorkerProfile();
        
        $skillsString = $profile->skills ? implode(', ', $profile->skills) : '';

        return view('admin.workers.edit', compact('worker', 'profile', 'skillsString'));
    }

    /**
     * Update worker user and profile data.
     */
    public function update(Request $request, $id)
    {
        $worker = $this->workerRepository->find($id);
        $profile = $worker->workerProfile;

        if (!$profile) {
            $profile = new WorkerProfile();
            $profile->user_id = $worker->id;
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $worker->id . ',_id'],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'bio' => ['required', 'string', 'max:2000'],
            'experience' => ['required', 'integer', 'min:0'],
            'skills' => ['required', 'string', 'max:1000'], // comma-separated
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'linkedin' => ['nullable', 'url'],
            'facebook' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Update user core
        $worker->name = $request->name;
        $worker->email = $request->email;
        $worker->status = $request->status;
        
        if ($request->filled('password')) {
            $worker->password = Hash::make($request->password);
        }
        $worker->save();

        // Update profile
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profiles', 'public');
            $profile->photo = $photoPath;
        }

        $skillsArray = array_map('trim', explode(',', $request->skills));
        $skillsArray = array_filter($skillsArray);

        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->bio = $request->bio;
        $profile->experience = (int) $request->experience;
        $profile->skills = $skillsArray;
        $profile->linkedin = $request->linkedin;
        $profile->facebook = $request->facebook;
        $profile->instagram = $request->instagram;
        $profile->save();

        return redirect()->route('admin.workers.show', $worker->id)
            ->with('success', __('messages.worker_update_success'));
    }

    /**
     * Delete worker user and profile.
     */
    public function destroy($id)
    {
        $worker = $this->workerRepository->find($id);
        
        if ($worker->workerProfile) {
            $worker->workerProfile->delete();
        }

        $worker->delete();

        return redirect()->route('admin.workers.index')
            ->with('success', __('messages.worker_delete_success'));
    }

    /**
     * Assign service to a worker.
     */
    public function assignService(Request $request, $id)
    {
        $request->validate([
            'service_id' => ['required', 'string'],
        ]);

        $this->assignmentService->assignWorker($id, $request->service_id);

        return redirect()->route('admin.workers.show', $id)
            ->with('success', __('messages.worker_assign_success'));
    }

    /**
     * Remove service from worker.
     */
    public function removeService(Request $request, $id)
    {
        $request->validate([
            'service_id' => ['required', 'string'],
        ]);

        $this->assignmentService->removeWorker($id, $request->service_id);

        return redirect()->route('admin.workers.show', $id)
            ->with('success', __('messages.worker_remove_success'));
    }
}
