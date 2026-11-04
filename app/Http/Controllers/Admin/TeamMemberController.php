<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of team members.
     */
    public function index(): View
    {
        $teamMembers = TeamMember::orderBy('order')->latest()->paginate(15);

        return view('admin.team.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create(): View
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created team member in storage.
     */
    public function store(Request $request): RedirectResponse
    {
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
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']).'-'.rand(100, 999);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        if ($request->hasFile('image')) {
            $destDir = public_path('uploads/team');
            if (! File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destDir, $imageName);
            $validated['image'] = 'uploads/team/'.$imageName;
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
        $member = $team;

        return view('admin.team.edit', compact('member'));
    }

    /**
     * Update the specified team member in storage.
     */
    public function update(Request $request, TeamMember $team): RedirectResponse
    {
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
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']).'-'.rand(100, 999);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        if ($request->hasFile('image')) {
            $destDir = public_path('uploads/team');
            if (! File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            if ($member->image && ! str_starts_with($member->image, 'assets/') && File::exists(public_path($member->image))) {
                File::delete(public_path($member->image));
            }
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destDir, $imageName);
            $validated['image'] = 'uploads/team/'.$imageName;
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
        $member = $team;

        if ($member->image && ! str_starts_with($member->image, 'assets/') && File::exists(public_path($member->image))) {
            File::delete(public_path($member->image));
        }

        $member->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'টিম মেম্বার সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
