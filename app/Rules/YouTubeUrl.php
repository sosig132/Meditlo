<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YouTubeUrl implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        $pattern = '%^(https?://)?(www\.)?'
            . '(youtube\.com/watch\?v=|youtu\.be/)'
            . '([a-zA-Z0-9_-]{11})(&.*)?$%';

        if (!preg_match($pattern, $value)) {
            $fail('The '.$attribute.' must be a valid YouTube URL.');
        }
    }
}
