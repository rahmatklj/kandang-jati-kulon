<?php

namespace App\Http\Controllers;

use App\Models\SurveiKepuasan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SurveiPublicController extends Controller
{
    public function index(Request $request)
    {
        $settingsRaw = Setting::all();
        $settings = $settingsRaw->pluck('value', 'key')->toArray();

        $tahunList = SurveiKepuasan::where('is_active', true)
            ->pluck('tahun')
            ->unique()
            ->sortDesc()
            ->values();

        $tahun = $request->get('tahun');
        $surveiId = $request->get('survei_id');

        $query = SurveiKepuasan::where('is_active', true);
        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        $surveis = $query->orderBy('tahun', 'desc')->orderBy('created_at', 'desc')->get();

        if ($surveiId) {
            $selectedSurvei = SurveiKepuasan::where('is_active', true)->find($surveiId);
        } else {
            $selectedSurvei = $surveis->first() ?? SurveiKepuasan::latest()->first();
        }

        $unsurLabels = SurveiKepuasan::getUnsurLabels();

        return view('public.survei.index', compact('settings', 'tahunList', 'tahun', 'surveis', 'selectedSurvei', 'unsurLabels'));
    }

    public function downloadPdf($id)
    {
        $survei = SurveiKepuasan::findOrFail($id);

        if (!$survei->pdf_file || !Storage::disk('public')->exists($survei->pdf_file)) {
            return back()->with('error', 'Berkas PDF laporan survei tidak ditemukan di server.');
        }

        return Storage::disk('public')->download($survei->pdf_file, 'Laporan_SKM_' . Str::slug($survei->periode) . '.pdf');
    }
}
