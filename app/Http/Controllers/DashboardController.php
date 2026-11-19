<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\View\View;

/** Dashboard ringkasan khusus admin (middleware 'admin' di route). */
class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totals = Pemesanan::toBase()
            ->selectRaw('COUNT(*) AS pemesanan')
            ->selectRaw('COALESCE(SUM(total_bayar), 0) AS pendapatan')
            ->selectRaw('COALESCE(SUM(raket), 0) AS raket')
            ->selectRaw('COALESCE(SUM(sepatu), 0) AS sepatu')
            ->selectRaw('COALESCE(SUM(bola), 0) AS bola')
            ->first();

        return view('dashboard.index', [
            'totals' => $totals,
            'totalUser' => User::regular()->count(),
            'terbaru' => Pemesanan::latest('id')->take(5)->get(),
        ]);
    }
}
