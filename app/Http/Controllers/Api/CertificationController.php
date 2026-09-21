<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CertificationResource;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index(Request $request)
    {
        $certifications = $request->user()
            ->certifications()
            ->latest('issue_date')
            ->get();

        return CertificationResource::collection($certifications);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'name' => ['required', 'string', 'max:255'],
            'issuing_organization' => ['required', 'string', 'max:255'],
            'credential_id' => ['nullable', 'string', 'max:255'],
            'credential_url' => ['nullable', 'url', 'max:255'],
            'issue_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'does_not_expire' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $request->user()
            ->cvs()
            ->findOrFail($validated['cv_id']);

        $certification = $request->user()
            ->certifications()
            ->create($validated);

        return (new CertificationResource($certification))
            ->additional([
                'success' => true,
                'message' => 'Certification added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Certification $certification)
    {
        if ($certification->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Certification not found.',
            ], 404);
        }

        return new CertificationResource($certification);
    }

    public function update(Request $request, Certification $certification)
    {
        if ($certification->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Certification not found.',
            ], 404);
        }

        $validated = $request->validate([
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'issuing_organization' => ['sometimes', 'required', 'string', 'max:255'],
            'credential_id' => ['nullable', 'string', 'max:255'],
            'credential_url' => ['nullable', 'url', 'max:255'],
            'issue_date' => ['sometimes', 'required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'does_not_expire' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        if (isset($validated['cv_id'])) {
            $request->user()
                ->cvs()
                ->findOrFail($validated['cv_id']);
        }

        $certification->update($validated);

        return (new CertificationResource($certification))
            ->additional([
                'success' => true,
                'message' => 'Certification updated successfully.',
            ]);
    }

    public function destroy(Request $request, Certification $certification)
    {
        if ($certification->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Certification not found.',
            ], 404);
        }

        $certification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Certification deleted successfully.',
        ]);
    }
}