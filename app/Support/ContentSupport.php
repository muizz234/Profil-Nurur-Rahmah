<?php

namespace App\Support;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class ContentSupport
{
    public const ALLOWED_IMAGE_MIMES = ['jpg', 'jpeg', 'png', 'webp'];

    public const MAX_IMAGE_KB = 2048;

    /**
     * Shared image validation rules (SVG is never allowed).
     *
     * @return array<int, string>
     */
    public static function imageRules(bool $required = false): array
    {
        return [
            $required ? 'required' : 'nullable',
            'image',
            'mimes:'.implode(',', self::ALLOWED_IMAGE_MIMES),
            'max:'.self::MAX_IMAGE_KB,
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function kegiatanCategoryOptions(): array
    {
        return [
            'tahfidz' => 'Tahfidz',
            'kitab_kuning' => 'Kitab Kuning',
            'formal' => 'Pendidikan Formal',
            'ekstrakurikuler' => 'Ekstrakurikuler',
        ];
    }

    /**
     * Build a unique slug for the given model class.
     *
     * @param  class-string<Model>  $modelClass
     */
    public static function uniqueSlug(string $modelClass, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'item';
        $slug = $base;
        $counter = 2;

        while (
            $modelClass::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }

    /**
     * Retry an operation that may fail with a duplicate-slug QueryException.
     *
     * The closure receives the attempt number (1-based) and should regenerate
     * its slug on each attempt via uniqueSlug().
     *
     * @template T
     *
     * @param  Closure(int): T  $operation
     */
    public static function retryOnDuplicateSlug(Closure $operation, int $maxAttempts = 3): mixed
    {
        $attempt = 0;

        while (true) {
            $attempt++;

            try {
                return $operation($attempt);
            } catch (QueryException $exception) {
                if ($attempt >= $maxAttempts || ! self::isDuplicateSlugException($exception)) {
                    throw $exception;
                }
            }
        }
    }

    public static function isDuplicateSlugException(QueryException $exception): bool
    {
        $message = strtolower($exception->getMessage());

        return $exception->getCode() === '23000'
            || $exception->getCode() === 23000
            || str_contains($message, 'duplicate')
            || str_contains($message, 'unique constraint')
            || str_contains($message, 'slug');
    }

    /**
     * Extract a URL from a Google Maps iframe or return the plain URL.
     * Returns null when the value is not a Google Maps URL.
     */
    public static function extractGoogleMapsUrl(string $value): ?string
    {
        $value = trim($value);

        if (preg_match('/<iframe[^>]*\ssrc=["\']([^"\']+)["\']/i', $value, $matches)) {
            $value = html_entity_decode($matches[1]);
        } elseif (str_contains(strtolower($value), '<iframe') || str_contains(strtolower($value), '<script')) {
            return null;
        }

        return self::isGoogleMapsUrl($value) ? $value : null;
    }

    public static function isGoogleMapsUrl(string $value): bool
    {
        $parts = parse_url(trim($value));

        if ($parts === false || ! isset($parts['scheme'], $parts['host'])) {
            return false;
        }

        if (! in_array(strtolower($parts['scheme']), ['http', 'https'], true)) {
            return false;
        }

        $host = strtolower($parts['host']);

        $isGoogleHost = $host === 'google.com'
            || $host === 'www.google.com'
            || str_ends_with($host, '.google.com');

        if (! $isGoogleHost) {
            return false;
        }

        $path = $parts['path'] ?? '';

        return str_starts_with($path, '/maps');
    }
}
