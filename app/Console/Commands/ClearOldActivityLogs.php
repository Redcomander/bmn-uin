<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\ActivityLog;

class ClearOldActivityLogs extends Command
{
    protected $signature = 'activity-log:clear';
    protected $description = 'Clear old activity logs';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Calculate the date 1 day ago
        $oneDayAgo = Carbon::now()->subDay();

        // Delete activity logs older than 1 day
        ActivityLog::where('created_at', '<', $oneDayAgo)->delete();

        $this->info('Old activity logs have been cleared.');
    }
}
