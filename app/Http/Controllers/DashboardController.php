<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard with statistics, search and pagination.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $sort = (string) $request->query('sort', 'created_at');
        $sort = in_array($sort, ['name', 'email', 'age', 'created_at'], true) ? $sort : 'created_at';

        $direction = strtolower((string) $request->query('direction', 'desc'));
        $direction = in_array($direction, ['asc', 'desc'], true) ? $direction : 'desc';

        $students = Student::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        $total = Student::count();

        return view('dashboard', [
            'students' => $students,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'stats' => [
                'total' => $total,
                'averageAge' => $total > 0 ? round((float) Student::avg('age'), 1) : null,
                'youngest' => Student::min('age'),
                'oldest' => Student::max('age'),
                'addedThisWeek' => Student::where('created_at', '>=', now()->subWeek())->count(),
            ],
        ]);
    }
}
