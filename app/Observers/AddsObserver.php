<?php

namespace App\Observers;

use App\Models\Adds;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AddsObserver
{
    /**
     * Handle the Adds "created" event.
     */
    public function created(Adds $adds): void
    {
        //
    }

    /**
     * Handle the Adds "updated" event.
     */
    public function updated(Adds $adds): void
    {
        if ($adds->wasChanged('text')) {
            $originalStatus = $adds->getOriginal('status');
            Adds::withoutEvents(function () use ($adds) {
                $adds->update(['status' => 'В ожидании']);
            });
            $cachedAdds = Cache::get('cached_adds', []);
            $cachedAdds[] = $adds->id;
            Cache::put('cached_adds', $cachedAdds);
            Cache::put('adds_status_'.$adds->id, $originalStatus, Carbon::now()->addMinutes(3));
        }

        if ($adds->wasChanged('budget')) {
            $oldBudget = $adds->getOriginal('budget');
            $newBudget = $adds->budget;

            if ($oldBudget == 0 && $newBudget > 0) {
                Adds::withoutEvents(function () use ($adds) {
                    $adds->update(['status' => 'Активен']);
                });
            }
        }
    }

    /**
     * Handle the Adds "deleted" event.
     */
    public function deleted(Adds $adds): void
    {
        //
    }

    /**
     * Handle the Adds "restored" event.
     */
    public function restored(Adds $adds): void
    {
        //
    }

    /**
     * Handle the Adds "force deleted" event.
     */
    public function forceDeleted(Adds $adds): void
    {
        //
    }
}
