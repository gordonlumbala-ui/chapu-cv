<?php

if (! function_exists('cv_type_label')) {
    function cv_type_label(?string $type): string
    {
        return match ($type) {
            'professional' => 'Professional CV',
            'academic' => 'Academic CV',
            'technical' => 'Technical CV',
            'job' => 'Job CV',
            'custom' => 'Custom CV',
            default => 'CV',
        };
    }

    if (! function_exists('format_date')) {
    function format_date($date, string $format = 'M Y'): string
    {
        if (! $date) {
            return '';
        }

        return \Carbon\Carbon::parse($date)->format($format);
    }
}




if (! function_exists('profile_completion')) {
    function profile_completion(array $sections): int
    {
        if (empty($sections)) {
            return 0;
        }

        $completed = count(array_filter($sections));
        $total = count($sections);

        return (int) round(($completed / $total) * 100);
    }
}



if (! function_exists('is_cv_public')) {
    function is_cv_public($cv): bool
    {
        return (bool) (
            $cv &&
            $cv->is_active &&
            $cv->is_public
        );
    }
}

if (! function_exists('cv_slug_url')) {
    function cv_slug_url($cv): string
    {
        if (! $cv || empty($cv->slug)) {
            return '';
        }

        return url('/cv/' . $cv->slug);
    }
}

}