<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::where('status', 'active')->count();

        $deletedStudents = Student::where('status', 'deleted')->count();

        // New students this month
        $newStudentsThisMonth = Student::where('status', 'active')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Latest active students
        $latestStudents = Student::where('status', 'active')
            ->latest()
            ->take(5)
            ->get();

        // Monthly registrations chart
        $monthlyRegistrations = Student::where('status', 'active')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'deletedStudents',
            'newStudentsThisMonth',
            'latestStudents',
            'monthlyRegistrations'
        ));
    }
}
