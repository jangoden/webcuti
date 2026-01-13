<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LeaveRequestController extends Controller
{
    /**
     * Display leave request form.
     */
    public function create(Request $request): View
    {
        $user = $request->user();
        $leaveTypes = LeaveType::all();

        return view('employee.leave.create', compact('user', 'leaveTypes'));
    }

    /**
     * Store a new leave request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Basic validation first
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:1000',
        ]);

        // 2. Check if selected Leave Type requires attachment
        $leaveType = LeaveType::find($request->leave_type_id);
        
        $attachmentRules = 'nullable';
        if ($leaveType && $leaveType->requires_attachment) {
            $attachmentRules = 'required';
        }

        // 3. Validate attachment dynamically AND re-validate/gather other fields for mass assignment
        $validated = $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:1000',
            'attachment' => "$attachmentRules|file|mimes:pdf,jpg,jpeg,png|max:2048",
        ], [
            'attachment.required' => "Untuk cuti jenis {$leaveType->name}, Anda WAJIB melampirkan dokumen pendukung (Surat Dokter, dll).",
        ]);

        $user = $request->user();

        // Calculate total days
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        // Check if user has enough leave quota
        $remainingLeave = $user->getRemainingLeave();
        if ($totalDays > $remainingLeave) {
            return back()->withErrors([
                'start_date' => "Sisa cuti Anda tidak mencukupi. Tersisa: {$remainingLeave} hari, diminta: {$totalDays} hari.",
            ])->withInput();
        }

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        LeaveRequest::create([
            'user_id' => $user->id,
            'leave_type_id' => $validated['leave_type_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $totalDays,
            'reason' => $validated['reason'],
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->route('pegawai.leave.history')
            ->with('success', 'Pengajuan cuti berhasil diajukan dan menunggu persetujuan.');
    }

    /**
     * Display leave history.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $leaveRequests = $user->leaveRequests()
            ->with('leaveType')
            ->latest()
            ->paginate(10);

        return view('employee.leave.history', compact('user', 'leaveRequests'));
    }

    /**
     * Export leave history to PDF.
     */
    public function exportPdf(Request $request): Response
    {
        $user = $request->user();

        $leaveRequests = $user->leaveRequests()
            ->with('leaveType')
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pdf.leave-history', compact('user', 'leaveRequests'));

        return $pdf->download('riwayat-cuti-' . $user->nip . '.pdf');
    }
}
