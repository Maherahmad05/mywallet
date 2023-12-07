<?php

namespace App\Http\Controllers;

use Elibyy\TCPDF\Facades\TCPDF;
Use App\Saving;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function periode(Request $request)
    {
        if ($request->has('tgl_awal')) {
            $savings = Saving::with(['student', 'month'])
                    ->latest('savings.created_at', [request('tgl_awal'), request('tgl_akhir')])
                    ->join('students', 'students.id', '=', 'savings.student_id')
                    ->join('months', 'months.id', '=', 'savings.month_id')
                    ->orderBy('students.kelas')
                    ->orderBy('months.name')
                    ->get()
                    ->groupBy('student_id')
                    ->map(function ($group) {
                        $totalPayment = $group->sum('nominal');
                        return [
                            'name' => $group->first()->student->name,
                            'kelas' => $group->first()->student->kelas,
                            'nameM' => $group->first()->month->name,
                            'nominal' => $totalPayment,
                        ];
                    })
                    ->values();
        }

        $pdf = PDF::loadView('savings.periode', compact('savings'))
                   ->setPaper('legal', 'landscape');

        return $pdf->stream('laporan_tabungan.pdf');

    }
}