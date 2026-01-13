<?php

namespace App\Services;

use App\Models\LeaveRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveReportService
{
    public function getWeeklyReport(?string $startDate = null, ?string $endDate = null): Collection
    {
        $start = $startDate ? Carbon::parse($startDate) : now()->startOfWeek();
        $end = $endDate ? Carbon::parse($endDate) : now()->endOfWeek();

        return $this->getReportData($start, $end);
    }

    public function getMonthlyReport(?int $year = null, ?int $month = null): Collection
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;
        
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = Carbon::create($year, $month, 1)->endOfMonth();

        return $this->getReportData($start, $end);
    }

    public function getYearlyReport(?int $year = null): Collection
    {
        $year = $year ?? now()->year;
        
        $start = Carbon::create($year, 1, 1)->startOfYear();
        $end = Carbon::create($year, 12, 31)->endOfYear();

        return $this->getReportData($start, $end);
    }

    protected function getReportData(Carbon $start, Carbon $end): Collection
    {
        return LeaveRequest::query()
            ->with(['user', 'leaveType'])
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy('user_id')
            ->map(function ($requests) {
                $user = $requests->first()->user;
                
                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'nip' => $user->nip,
                    'jabatan' => $user->jabatan,
                    'total_requests' => $requests->count(),
                    'approved' => $requests->where('status', 'approved')->count(),
                    'pending' => $requests->where('status', 'pending')->count(),
                    'rejected' => $requests->where('status', 'rejected')->count(),
                    'total_days' => $requests->where('status', 'approved')->sum('total_days'),
                    'requests' => $requests,
                ];
            })
            ->values();
    }

    public function calculateStatistics(Collection $data): array
    {
        return [
            'total_requests' => $data->sum('total_requests'),
            'total_approved' => $data->sum('approved'),
            'total_pending' => $data->sum('pending'),
            'total_rejected' => $data->sum('rejected'),
            'total_leave_days' => $data->sum('total_days'),
            'total_employees' => $data->count(),
        ];
    }
}
