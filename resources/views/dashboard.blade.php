
@extends('layouts.admin')

@section('title', 'Dashboard | Student Management')
@section('heading', 'Dashboard Overview')

@section('content')

<style>
    .smart-dashboard {
        --primary: #4f46e5;
        --text: #172033;
        --muted: #7b879b;
        --line: #edf0f6;
        color: var(--text);
        padding-bottom: 24px;
    }

    .smart-dashboard * {
        box-sizing: border-box;
    }

    .smart-dashboard .muted {
        color: var(--muted);
    }

    /* Welcome banner */
    .dashboard-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 22px;
        padding: 30px;
        margin-bottom: 25px;
        border-radius: 20px;
        color: white;
        background: linear-gradient(115deg, #3730a3, #5b4fe9 60%, #818cf8);
        box-shadow: 0 12px 28px rgba(79, 70, 229, .15);
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        width: 250px;
        height: 250px;
        right: 13%;
        top: -155px;
        border: 35px solid rgba(255,255,255,.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 12px;
        color: #e0e7ff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .hero-title {
        margin: 0 0 9px;
        color: #fff;
        font-size: clamp(23px, 3vw, 31px);
        font-weight: 800;
        letter-spacing: -.8px;
    }

    .hero-description {
        margin: 0;
        color: #e0e7ff;
        font-size: 13px;
        line-height: 1.8;
    }

    .hero-date {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 17px;
        padding: 8px 12px;
        color: #fff;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 9px;
        font-size: 12px;
    }

    .hero-actions {
        position: relative;
        z-index: 1;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .hero-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        min-height: 43px;
        padding: 0 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .hero-btn-primary {
        color: #4338ca;
        background: white;
        border: 1px solid white;
    }

    .hero-btn-primary:hover {
        color: #312e81;
        background: #eef2ff;
        transform: translateY(-2px);
    }

    .hero-btn-secondary {
        color: white;
        border: 1px solid rgba(255,255,255,.4);
        background: rgba(255,255,255,.1);
    }

    .hero-btn-secondary:hover {
        color: white;
        background: rgba(255,255,255,.2);
    }

    /* Section headings */
    .dashboard-section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .dashboard-section-heading h5 {
        margin: 0 0 5px;
        color: var(--text);
        font-size: 16px;
        font-weight: 800;
    }

    .dashboard-section-heading p {
        margin: 0;
        color: var(--muted);
        font-size: 12px;
    }

    .section-kicker {
        color: var(--primary);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    /* Statistics */
    .smart-stat-card {
        position: relative;
        height: 100%;
        min-height: 160px;
        padding: 21px;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(31, 52, 88, .035);
        transition: transform .22s ease, box-shadow .22s ease;
    }

    .smart-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(31, 52, 88, .085);
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .stat-label {
        color: #68758b;
        font-size: 12px;
        font-weight: 650;
    }

    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        border-radius: 13px;
        font-size: 20px;
    }

    .stat-blue { color: #4f46e5; background: #eef2ff; }
    .stat-green { color: #059669; background: #e8f8f0; }
    .stat-purple { color: #9333ea; background: #f5eaff; }
    .stat-orange { color: #d97706; background: #fff4df; }

    .stat-number {
        margin: 18px 0 7px;
        color: #172033;
        font-size: 32px;
        font-weight: 850;
        line-height: 1.1;
        letter-spacing: -1px;
    }

    .stat-foot {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #8a95a7;
        font-size: 11px;
    }

    .stat-foot i {
        color: #10b981;
    }

    /* Main panels */
    .smart-panel {
        height: 100%;
        padding: 23px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 17px;
        box-shadow: 0 4px 18px rgba(31, 52, 88, .035);
    }

    .panel-title {
        margin: 0 0 5px;
        color: #202b40;
        font-size: 15px;
        font-weight: 800;
    }

    .panel-subtitle {
        margin: 0;
        color: var(--muted);
        font-size: 11px;
    }

    .chart-wrap {
        position: relative;
        height: 290px;
        margin-top: 22px;
    }

    .chart-year {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        color: #4f46e5;
        background: #eef2ff;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 750;
    }

    .chart-summary {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--line);
        color: var(--muted);
        font-size: 11px;
    }

    .chart-legend-dot {
        width: 9px;
        height: 9px;
        background: #6366f1;
        border-radius: 50%;
    }

    /* Recent student table */
    .student-search-wrap {
        position: relative;
        width: 100%;
        max-width: 255px;
    }

    .student-search-wrap i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .student-search {
        width: 100%;
        min-height: 41px;
        padding: 9px 12px 9px 36px;
        color: #263247;
        background: #f8faff;
        border: 1px solid #e7ebf3;
        border-radius: 10px;
        outline: none;
        font-size: 12px;
        transition: .2s;
    }

    .student-search:focus {
        border-color: #818cf8;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    }

    .smart-table {
        margin: 0;
        min-width: 650px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .smart-table thead th {
        padding: 14px 15px;
        color: #8390a5;
        background: #f8faff;
        border-top: 1px solid #f0f2f7;
        border-bottom: 1px solid #edf0f6;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .65px;
        white-space: nowrap;
    }

    .smart-table thead th:first-child {
        border-radius: 9px 0 0 9px;
    }

    .smart-table thead th:last-child {
        border-radius: 0 9px 9px 0;
    }

    .smart-table tbody td {
        padding: 15px;
        color: #59667c;
        border-bottom: 1px solid #f0f2f7;
        font-size: 12px;
        vertical-align: middle;
    }

    .smart-table tbody tr:last-child td {
        border-bottom: none;
    }

    .smart-table tbody tr {
        transition: background .15s;
    }

    .smart-table tbody tr:hover {
        background: #fafbff;
    }

    .student-identity {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 170px;
    }

    .student-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        overflow: hidden;
        color: #4f46e5;
        background: #eef2ff;
        border: 1px solid #e0e7ff;
        border-radius: 12px;
        font-size: 17px;
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-name {
        display: block;
        margin-bottom: 4px;
        color: #263247;
        font-size: 12px;
        font-weight: 750;
        overflow-wrap: anywhere;
    }

    .student-id {
        color: #9aa4b5;
        font-size: 10px;
    }

    .email-cell {
        overflow-wrap: anywhere;
    }

    .date-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 9px;
        color: #526079;
        background: #f5f7fb;
        border: 1px solid #edf0f6;
        border-radius: 8px;
        font-size: 10px;
        white-space: nowrap;
    }

    .empty-state {
        padding: 45px 15px !important;
        text-align: center;
    }

    .empty-state-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        margin: 0 auto 14px;
        color: #6366f1;
        background: #eef2ff;
        border-radius: 18px;
        font-size: 25px;
    }

    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 17px;
        margin-top: 12px;
        border-top: 1px solid var(--line);
    }

    .table-footer small {
        color: var(--muted);
        font-size: 11px;
    }

    .view-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        color: white;
        background: #4f46e5;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s;
    }

    .view-all-btn:hover {
        color: white;
        background: #4338ca;
        transform: translateY(-1px);
    }

    .no-search-results {
        display: none;
        padding: 25px 10px;
        color: #7b879b;
        text-align: center;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 23px;
        }

        .smart-panel {
            padding: 18px;
        }

        .chart-wrap {
            height: 250px;
        }
    }

    @media (max-width: 480px) {
        .dashboard-hero {
            padding: 20px;
            border-radius: 15px;
        }

        .hero-actions {
            width: 100%;
        }

        .hero-btn {
            flex: 1;
        }

        .smart-stat-card {
            min-height: 145px;
            padding: 17px;
        }

        .stat-number {
            font-size: 28px;
        }

        .student-search-wrap {
            max-width: 100%;
        }

        .table-footer {
            align-items: flex-start;
        }
    }
</style>

<div class="smart-dashboard">

    {{-- Welcome banner --}}
    <section class="dashboard-hero">
        <div class="hero-content">
            <div class="hero-eyebrow">
                <i class="bi bi-stars"></i>
                STUDENT MANAGEMENT PORTAL
            </div>

            <h2 class="hero-title">Welcome back, Administrator!</h2>

            <p class="hero-description">
                Your student overview, registration activity and latest records
                are all in one place.
            </p>

            <div class="hero-date">
                <i class="bi bi-calendar3"></i>
                {{ now()->format('l, d F Y') }}
            </div>
        </div>

        <div class="hero-actions">
            <a href="{{ route('students.index') }}" class="hero-btn hero-btn-primary">
                <i class="bi bi-people-fill"></i>
                Manage Students
            </a>

            <a href="{{ route('students.index') }}" class="hero-btn hero-btn-secondary">
                <i class="bi bi-arrow-up-right"></i>
                Student Records
            </a>
        </div>
    </section>

    {{-- Section heading --}}
    <div class="dashboard-section-heading">
        <div>
            <div class="section-kicker mb-2">AT A GLANCE</div>
            <h5>Student Statistics</h5>
            <p>Key information about your student records.</p>
        </div>
    </div>

    {{-- Statistic cards --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="smart-stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Students</span>
                    <div class="stat-icon stat-blue">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalStudents) }}</div>
                <div class="stat-foot">
                    <i class="bi bi-check-circle-fill"></i>
                    All registered student records
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="smart-stat-card">
                <div class="stat-top">
                    <span class="stat-label">New This Month</span>
                    <div class="stat-icon stat-green">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($newStudentsThisMonth) }}</div>
                <div class="stat-foot">
                    <i class="bi bi-calendar-check"></i>
                    Registrations in {{ now()->format('F') }}
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="smart-stat-card">
                <div class="stat-top">
                    <span class="stat-label">Recent Records</span>
                    <div class="stat-icon stat-purple">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $latestStudents->count() }}</div>
                <div class="stat-foot">
                    <i class="bi bi-info-circle"></i>
                    Students in the recent list
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="smart-stat-card">
                <div class="stat-top">
                    <span class="stat-label">Reporting Period</span>
                    <div class="stat-icon stat-orange">
                        <i class="bi bi-calendar2-week"></i>
                    </div>
                </div>
                <div class="stat-number">{{ now()->format('M Y') }}</div>
                <div class="stat-foot">
                    <i class="bi bi-graph-up-arrow"></i>
                    Current reporting month
                </div>
            </div>
        </div>

    </div>

    {{-- Registration analytics --}}
    <div class="dashboard-section-heading mt-4">
        <div>
            <div class="section-kicker mb-2">ANALYTICS</div>
            <h5>Registration Overview</h5>
            <p>Explore student registration activity throughout the year.</p>
        </div>
    </div>

    <section class="smart-panel mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h6 class="panel-title">Monthly Student Registrations</h6>
                <p class="panel-subtitle">
                    Number of student records created in {{ now()->year }}
                </p>
            </div>

            <span class="chart-year">
                <i class="bi bi-calendar3"></i>
                {{ now()->year }}
            </span>
        </div>

        <div class="chart-wrap">
            <canvas id="studentRegistrationChart"
                    aria-label="Monthly student registrations chart"
                    role="img"></canvas>
        </div>

        <div class="chart-summary">
            <span class="chart-legend-dot"></span>
            <span>New registrations</span>
            <span class="ms-auto">
                {{ number_format($newStudentsThisMonth) }} this month
            </span>
        </div>
    </section>

    {{-- Recent student records --}}
    <section class="smart-panel">
        <div class="dashboard-section-heading mb-4">
            <div>
                <div class="section-kicker mb-2">STUDENT DIRECTORY</div>
                <h5>Recently Registered Students</h5>
                <p>Review the latest records added to the system.</p>
            </div>

            <div class="student-search-wrap">
                <i class="bi bi-search"></i>
                <input type="search"
                       id="studentSearch"
                       class="student-search"
                       placeholder="Search name, email or phone..."
                       aria-label="Search recent students">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table smart-table align-middle" id="studentsTable">
                <thead>
                    <tr>
                        <th>STUDENT</th>
                        <th>EMAIL ADDRESS</th>
                        <th>PHONE NUMBER</th>
                        <th>REGISTERED DATE</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($latestStudents as $student)
                        <tr>
                            <td>
                                <div class="student-identity">
                                    <div class="student-avatar">
                                        @if ($student->profile_image)
                                            <img
                                                src="{{ asset('storage/' . $student->profile_image) }}"
                                                alt="{{ $student->name }} profile photo"
                                                loading="lazy">
                                        @else
                                            <i class="bi bi-person-fill"></i>
                                        @endif
                                    </div>

                                    <div>
                                        <span class="student-name">
                                            {{ $student->name }}
                                        </span>
                                        <span class="student-id">
                                            Student #{{ $student->id }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="email-cell">{{ $student->email }}</td>

                            <td>{{ $student->phone ?: 'Not provided' }}</td>

                            <td>
                                <span class="date-pill">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $student->created_at
                                        ? $student->created_at->format('d M Y')
                                        : '—' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6 class="fw-bold mb-2">No students registered yet</h6>
                                <p class="muted small mb-3">
                                    Add your first student to start building your directory.
                                </p>
                                <a href="{{ route('students.index') }}"
                                   class="view-all-btn">
                                    <i class="bi bi-person-plus"></i>
                                    Go to Students
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="noSearchResults" class="no-search-results">
            <i class="bi bi-search me-1"></i>
            No matching students found in the recent records.
        </div>

        <div class="table-footer">
            <small>
                Showing <strong id="visibleStudentCount">{{ $latestStudents->count() }}</strong>
                of {{ $latestStudents->count() }} recent records
            </small>

            <a href="{{ route('students.index') }}" class="view-all-btn">
                View All Students
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </section>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Monthly registration chart
    const chartCanvas = document.getElementById('studentRegistrationChart');

    if (chartCanvas && typeof Chart !== 'undefined') {
        const registrationLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        const registrationData = Array(12).fill(0);

        @foreach($monthlyRegistrations as $registration)
            registrationData[{{ $registration->month - 1 }}] =
                {{ $registration->total }};
        @endforeach

        new Chart(chartCanvas, {
            type: 'line',
            data: {
                labels: registrationLabels,
                datasets: [{
                    label: 'New registrations',
                    data: registrationData,
                    borderColor: '#6366f1',
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const area = chart.chartArea;

                        if (!area) return 'rgba(99, 102, 241, 0.10)';

                        const gradient = chart.ctx.createLinearGradient(
                            0, area.top, 0, area.bottom
                        );

                        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.23)');
                        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.01)');

                        return gradient;
                    },
                    fill: true,
                    tension: 0.38,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#172033',
                        padding: 12,
                        cornerRadius: 9,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Registrations: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            padding: 10
                        },
                        border: { display: false },
                        grid: { color: '#edf0f6' }
                    },
                    x: {
                        border: { display: false },
                        grid: { display: false },
                        ticks: { color: '#7b879b' }
                    }
                }
            }
        });
    }

    // Search the recent student records
    const searchInput = document.getElementById('studentSearch');
    const table = document.getElementById('studentsTable');
    const noResults = document.getElementById('noSearchResults');
    const visibleCount = document.getElementById('visibleStudentCount');

    if (searchInput && table) {
        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            let visible = 0;

            rows.forEach(function(row) {
                // Ignore the initial empty-state row
                if (row.querySelector('.empty-state')) return;

                const matches = row.innerText.toLowerCase().includes(query);
                row.style.display = matches ? '' : 'none';

                if (matches) visible++;
            });

            if (visibleCount) visibleCount.textContent = visible;

            if (noResults) {
                noResults.style.display =
                    query !== '' && visible === 0 ? 'block' : 'none';
            }
        });
    }
});
</script>

@endsection
