<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWorkerProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\WorkerProfile;

class ProfileController extends Controller
{
    /**
     * Show worker profile edit view.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->workerProfile ?? new WorkerProfile();
        
        // Convert skills array back to comma-separated string for easy editing
        $skillsString = $profile->skills ? implode(', ', $profile->skills) : '';

        return view('worker.profile', compact('user', 'profile', 'skillsString'));
    }

    /**
     * Update worker profile details.
     */
    public function update(UpdateWorkerProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->workerProfile;
        
        if (!$profile) {
            $profile = new WorkerProfile();
            $profile->user_id = $user->id;
        }

        $data = $request->validated();
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profiles', 'public');
            $data['photo'] = $path;
        }

        // Process comma-separated skills into array
        $skillsArray = array_map('trim', explode(',', $data['skills']));
        $data['skills'] = array_filter($skillsArray); // remove empty values

        $profile->fill($data);
        $profile->save();

        return redirect()->route('worker.profile.edit')
            ->with('success', 'Your profile details have been updated successfully!');
    }

    /**
     * Update worker password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('worker.profile.edit')
            ->with('success', 'Your password has been changed successfully!');
    }
}
