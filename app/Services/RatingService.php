<?php

namespace App\Services;

use App\Models\TutorRating;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class RatingService
{
  const CACHE_KEY = 'global_average_rating';
  const CACHE_TTL_HOURS = 3;

  /**
   * Compute the global average rating and the rating count and cache them.
   *
   * @return float
   */
  public function computeAndCacheGlobalRatingAverage()
  {
    $average = (float) TutorRating::avg('rating') ?? 0.0;
    Cache::put(self::CACHE_KEY, $average, now()->addHours(self::CACHE_TTL_HOURS));
    return $average;
  }

  /**
   * Get the cached global rating data or compute it if not cached.
   *
   * @return float
   */
  public function getCachedGlobalRatingData()
  {
    return Cache::remember(self::CACHE_KEY, now()->addHours(self::CACHE_TTL_HOURS), function () {
      return $this->computeAndCacheGlobalRatingAverage();
    });
  }

  /**
   * Forget the cached global rating data.
   */
  public function forgetCachedGlobalRatingAverage()
  {
    Cache::forget(self::CACHE_KEY);
  }

  /**
   * Get only the average value from the cached data.
   *
   * @return float
   */
  public function getCachedGlobalAverage(): float
  {
    return $this->getCachedGlobalRatingData();
  }

  /**
   * Compute the bayesian average with a time decay factor
   * 
   * @param float $userRatingAverage
   * @param int $userRatingCount
   * @return float
   */

  public function computeBayesianAverage(float $userRatingAverage, int $userRatingCount): float
  {
    $globalAverage = $this->getCachedGlobalAverage();
    $globalRatingCount = TutorRating::count();
    if ($globalRatingCount === 0) {
      return $userRatingAverage;
    }
    if ($userRatingCount === 0) {
      return 0.0;
    }

    return ($userRatingAverage * $userRatingCount + $globalAverage * $globalRatingCount) / ($userRatingCount + $globalRatingCount);
  }

  /**
   * Compute the weighted average
   *
   * @param int $tutorId
   * @param float $lambda
   * @return array
   */
  public function computeWeightedAverage(int $tutorId, float $lambda = 0.5): array
  {

    $ratings = TutorRating::where('tutor_id', $tutorId)->get(['rating', 'created_at']);
    if ($ratings->isEmpty()) {
      return ['average' => 0, 'count' => 0];
    }

    $now = Carbon::now();
    $weightedSum = 0;
    $totalWeight = 0;

    foreach ($ratings as $rating) {
      $ageInDays = $now->diffInDays($rating->created_at);
      $weight = exp(-$lambda * $ageInDays);
      $weightedSum += $rating->rating * $weight;
      $totalWeight += $weight;
    }
    if ($totalWeight === 0) {
      return ['average' => 0, 'count' => 0];
    }

    return [
      'average' => $weightedSum / $totalWeight,
      'count' => $ratings->count(),
    ];
  }
}
