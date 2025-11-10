<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use Inertia\Inertia;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = Audit::query()->with('user');

        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('table')) {
            $query->where('auditable_type', 'like', '%' . $request->table . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $audits = $query->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Auditoria/Index', [
            'audits' => $audits,
            'filters' => $request->only(['user', 'event', 'table', 'date']),
        ]);
    }

    public function show($id)
    {
        $audit = Audit::with('user')->findOrFail($id);

        return Inertia::render('Auditoria/Show', [
            'audit' => $audit,
        ]);
    }
}
