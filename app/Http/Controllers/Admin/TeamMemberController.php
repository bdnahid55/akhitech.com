<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of team members.
     */
    public function index(): View
    {
        Gate::authorize('team.view');

        $teamMembers = TeamMember::orderBy('order')->latest()->paginate(15);

        return view('admin.team.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create(): View
    {
        Gate::authorize('team.create');

        return view('admin.team.create');
    }

    /**
     * Store a newly created team member in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('team.create');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:team_members,slug'],
            'designation' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'behance' => ['nullable', 'url', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'image' => FileUploadService::imageRules(),
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']).'-'.rand(100, 999);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        if ($request->hasFile('image')) {
            $validated['image'] = FileUploadService::storeImage($request->file('image'), 'team');
        }

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')
            ->with('success', 'টিম মেম্বার সফলভাবে যুক্ত করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit(TeamMember $team): View
    {
        Gate::authorize('team.edit');

        $member = $team;

        return view('admin.team.edit', compact('member'));
    }

    /**
     * Update the specified team member in storage.
     */
    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        Gate::authorize('team.edit');

        $member = $team;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:team_members,slug,'.$member->id],
            'designation' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'behance' => ['nullable', 'url', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'image' => FileUploadService::imageRules(),
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']).'-'.rand(100, 999);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        if ($request->hasFile('image')) {
            FileUploadService::deleteOldImage($member->image);
            $validated['image'] = FileUploadService::storeImage($request->file('image'), 'team');
        }

        $member->update($validated);

        return redirect()->route('admin.team.index')
            ->with('success', 'টিম মেম্বারের তথ্য সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified team member from storage.
     */
    public function destroy(TeamMember $team): RedirectResponse
    {
        Gate::authorize('team.delete');

        $member = $team;

        FileUploadService::deleteOldImage($member->image);

        $member->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'টিম মেম্বার সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
