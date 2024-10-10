<?php

namespace App\Jobs;

use App\Models\Adds;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class CheckAddsStatusJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cachedAdsKey = 'cached_adds';
        $cachedAds = Cache::get($cachedAdsKey, []);

        $validAds = [];
        $adds = [];

        foreach ($cachedAds as $adId) {
            $status = Cache::get('adds_status_'.$adId);

            if ($status) {
                $adds[] = [
                    'id' => $adId,
                    'status' => $status,
                ];

                $validAds[] = $adId;
            } else {
                Adds::where('id', $adId)->update(compact('status'));
            }
        }

        Cache::put($cachedAdsKey, $validAds, now()->addMinutes(3));
    }
}
