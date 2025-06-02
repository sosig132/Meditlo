<?php

namespace App\Console\Commands;

use App\Services\RatingService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class CacheGlobalAverageData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache-global-rating-average';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * The RatingService instance.
     *
     * @var RatingService
     */
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        parent::__construct();
        $this->ratingService = $ratingService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $average = $this->ratingService->computeAndCacheGlobalRatingAverage();
        $this->info("Global average rating cached successfully: {$average}");
        
        return SymfonyCommand::SUCCESS;
    }
}
