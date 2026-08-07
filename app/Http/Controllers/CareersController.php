<?php

namespace App\Http\Controllers;

use App\Models\CultureItem;
use App\Models\JobApplication;
use App\Models\JobOpening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareersController extends Controller
{
    public function index(): View
    {
        return view('careers.index', [
            'cultureItems' => CultureItem::orderBy('sort_order')->get(),
            'jobOpenings' => JobOpening::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function apply(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'position' => ['required', 'string', 'max:255'],
            'cover_note' => ['nullable', 'string', 'max:2000'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $cv = $request->file('cv');
        $path = $cv->store('cvs', 'local');

        $jobOpening = JobOpening::where('title', $validated['position'])->first();

        JobApplication::create([
            'job_opening_id' => $jobOpening?->id,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'cover_note' => $validated['cover_note'] ?? null,
            'cv_path' => $path,
            'cv_original_name' => $cv->getClientOriginalName(),
        ]);

        return redirect()->route('careers.index')->with('applied', true);
    }
}
