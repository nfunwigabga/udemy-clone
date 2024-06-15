<?php

namespace Database\Seeders;

use App\Enums\PeriodStatus;
use App\Models\Period;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $start_year = now()->startOfYear();
        $end_year = $start_year->copy()->endOfYear()->addYears(5);
        $periods = CarbonPeriod::since($start_year)->months(1)->until($end_year);

        // $interval = '1 month';
        // $periods = CarbonPeriod::create($start_year, $interval, $end_year);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Period::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($periods as $date) {
            $start = $date->copy();
            // give time for students to request a refund within 30 days.
            // so add 60 days to allow those who purchased at the end of the month
            // to get their 30 days refund window.
            $end = $date->copy()->addMonths(2);
            $now = Carbon::now('UTC');
            $payout_date = $end->copy()->addWeek(); // 1 week to process payments
            $status = $payout_date < $now->startOfMonth()
                ? PeriodStatus::CLOSED
                : PeriodStatus::OPEN;

            Period::create([
                'start_time' => $start,
                // 'end_time' => $end,
                'payout_date' => $payout_date,
                'status' => $status,
            ]);
        }
    }
}
