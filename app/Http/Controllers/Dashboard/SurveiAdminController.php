<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SurveiKepuasan;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SurveiAdminController extends Controller
{
    public function index()
    {
        $surveis = SurveiKepuasan::orderBy('tahun', 'desc')->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.survei.index', compact('surveis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',
            'periode' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'total_responden' => 'required|integer|min:1',
            'ikm_score' => 'nullable|numeric|min:25|max:100',
            'ikm_score_manual' => 'nullable|numeric|min:25|max:100',
            'u1_persyaratan' => 'nullable|numeric|min:1|max:4',
            'u2_prosedur' => 'nullable|numeric|min:1|max:4',
            'u3_waktu' => 'nullable|numeric|min:1|max:4',
            'u4_biaya' => 'nullable|numeric|min:1|max:4',
            'u5_produk' => 'nullable|numeric|min:1|max:4',
            'u6_kompetensi' => 'nullable|numeric|min:1|max:4',
            'u7_perilaku' => 'nullable|numeric|min:1|max:4',
            'u8_pengaduan' => 'nullable|numeric|min:1|max:4',
            'u9_sarpras' => 'nullable|numeric|min:1|max:4',
            'pdf_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp,gif,svg|max:10240',
        ], [
            'tahun.required' => 'Tahun periode survei wajib diisi.',
            'periode.required' => 'Nama periode (misal: Semester I - 2026) wajib diisi.',
            'title.required' => 'Judul laporan survei wajib diisi.',
            'total_responden.required' => 'Jumlah total responden wajib diisi.',
            'pdf_file.mimes' => 'Berkas laporan harus berformat PDF atau Foto/Gambar.',
            'pdf_file.max' => 'Ukuran berkas maksimal 10MB.',
        ]);

        $data = $request->only(['tahun', 'periode', 'title', 'total_responden']);
        $ikmInput = $request->input('ikm_score', $request->input('ikm_score_manual'));

        if ($ikmInput && (!$request->filled('u1_persyaratan') || !$request->filled('u2_prosedur'))) {
            $baseVal = round(floatval($ikmInput) / 25.0, 2);
            $data['u1_persyaratan'] = floatval($request->input('u1_persyaratan', $baseVal));
            $data['u2_prosedur'] = floatval($request->input('u2_prosedur', $baseVal));
            $data['u3_waktu'] = floatval($request->input('u3_waktu', $baseVal));
            $data['u4_biaya'] = floatval($request->input('u4_biaya', 4.00));
            $data['u5_produk'] = floatval($request->input('u5_produk', $baseVal));
            $data['u6_kompetensi'] = floatval($request->input('u6_kompetensi', $baseVal));
            $data['u7_perilaku'] = floatval($request->input('u7_perilaku', $baseVal));
            $data['u8_pengaduan'] = floatval($request->input('u8_pengaduan', $baseVal));
            $data['u9_sarpras'] = floatval($request->input('u9_sarpras', $baseVal));
            $ikmScore = floatval($ikmInput);
        } else {
            $data['u1_persyaratan'] = floatval($request->input('u1_persyaratan', 3.55));
            $data['u2_prosedur'] = floatval($request->input('u2_prosedur', 3.48));
            $data['u3_waktu'] = floatval($request->input('u3_waktu', 3.40));
            $data['u4_biaya'] = floatval($request->input('u4_biaya', 4.00));
            $data['u5_produk'] = floatval($request->input('u5_produk', 3.60));
            $data['u6_kompetensi'] = floatval($request->input('u6_kompetensi', 3.52));
            $data['u7_perilaku'] = floatval($request->input('u7_perilaku', 3.65));
            $data['u8_pengaduan'] = floatval($request->input('u8_pengaduan', 3.45));
            $data['u9_sarpras'] = floatval($request->input('u9_sarpras', 3.50));

            $sum = $data['u1_persyaratan'] + $data['u2_prosedur'] + $data['u3_waktu'] +
                   $data['u4_biaya'] + $data['u5_produk'] + $data['u6_kompetensi'] +
                   $data['u7_perilaku'] + $data['u8_pengaduan'] + $data['u9_sarpras'];

            $ikmScore = round(($sum / 9.0) * 25.0, 2);
            if ($ikmInput) {
                $ikmScore = floatval($ikmInput);
            }
        }

        $data['ikm_score'] = $ikmScore;
        $data['mutu_layanan'] = SurveiKepuasan::determineMutuLayanan($ikmScore);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('survei', 'public');
            $data['pdf_file'] = $path;
        }

        $survei = SurveiKepuasan::create($data);

        ActivityLogger::log('CREATE', 'Survei SKM', "Menambahkan periode survei kepuasan baru: {$survei->periode} (IKM: {$survei->ikm_score})");

        return back()->with('success', 'Data Hasil Survei Kepuasan Masyarakat (SKM) berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $survei = SurveiKepuasan::findOrFail($id);

        $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',
            'periode' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'total_responden' => 'required|integer|min:1',
            'ikm_score' => 'nullable|numeric|min:25|max:100',
            'ikm_score_manual' => 'nullable|numeric|min:25|max:100',
            'u1_persyaratan' => 'nullable|numeric|min:1|max:4',
            'u2_prosedur' => 'nullable|numeric|min:1|max:4',
            'u3_waktu' => 'nullable|numeric|min:1|max:4',
            'u4_biaya' => 'nullable|numeric|min:1|max:4',
            'u5_produk' => 'nullable|numeric|min:1|max:4',
            'u6_kompetensi' => 'nullable|numeric|min:1|max:4',
            'u7_perilaku' => 'nullable|numeric|min:1|max:4',
            'u8_pengaduan' => 'nullable|numeric|min:1|max:4',
            'u9_sarpras' => 'nullable|numeric|min:1|max:4',
            'pdf_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp,gif,svg|max:10240',
        ]);

        $data = $request->only(['tahun', 'periode', 'title', 'total_responden']);
        $ikmInput = $request->input('ikm_score', $request->input('ikm_score_manual'));

        if ($ikmInput && (!$request->filled('u1_persyaratan') || !$request->filled('u2_prosedur'))) {
            $baseVal = round(floatval($ikmInput) / 25.0, 2);
            $data['u1_persyaratan'] = floatval($request->input('u1_persyaratan', $survei->u1_persyaratan ?: $baseVal));
            $data['u2_prosedur'] = floatval($request->input('u2_prosedur', $survei->u2_prosedur ?: $baseVal));
            $data['u3_waktu'] = floatval($request->input('u3_waktu', $survei->u3_waktu ?: $baseVal));
            $data['u4_biaya'] = floatval($request->input('u4_biaya', $survei->u4_biaya ?: 4.00));
            $data['u5_produk'] = floatval($request->input('u5_produk', $survei->u5_produk ?: $baseVal));
            $data['u6_kompetensi'] = floatval($request->input('u6_kompetensi', $survei->u6_kompetensi ?: $baseVal));
            $data['u7_perilaku'] = floatval($request->input('u7_perilaku', $survei->u7_perilaku ?: $baseVal));
            $data['u8_pengaduan'] = floatval($request->input('u8_pengaduan', $survei->u8_pengaduan ?: $baseVal));
            $data['u9_sarpras'] = floatval($request->input('u9_sarpras', $survei->u9_sarpras ?: $baseVal));
            $ikmScore = floatval($ikmInput);
        } else {
            $data['u1_persyaratan'] = floatval($request->input('u1_persyaratan', $survei->u1_persyaratan ?: 3.55));
            $data['u2_prosedur'] = floatval($request->input('u2_prosedur', $survei->u2_prosedur ?: 3.48));
            $data['u3_waktu'] = floatval($request->input('u3_waktu', $survei->u3_waktu ?: 3.40));
            $data['u4_biaya'] = floatval($request->input('u4_biaya', $survei->u4_biaya ?: 4.00));
            $data['u5_produk'] = floatval($request->input('u5_produk', $survei->u5_produk ?: 3.60));
            $data['u6_kompetensi'] = floatval($request->input('u6_kompetensi', $survei->u6_kompetensi ?: 3.52));
            $data['u7_perilaku'] = floatval($request->input('u7_perilaku', $survei->u7_perilaku ?: 3.65));
            $data['u8_pengaduan'] = floatval($request->input('u8_pengaduan', $survei->u8_pengaduan ?: 3.45));
            $data['u9_sarpras'] = floatval($request->input('u9_sarpras', $survei->u9_sarpras ?: 3.50));

            $sum = $data['u1_persyaratan'] + $data['u2_prosedur'] + $data['u3_waktu'] +
                   $data['u4_biaya'] + $data['u5_produk'] + $data['u6_kompetensi'] +
                   $data['u7_perilaku'] + $data['u8_pengaduan'] + $data['u9_sarpras'];

            $ikmScore = round(($sum / 9.0) * 25.0, 2);
            if ($ikmInput) {
                $ikmScore = floatval($ikmInput);
            }
        }

        $data['ikm_score'] = $ikmScore;
        $data['mutu_layanan'] = SurveiKepuasan::determineMutuLayanan($ikmScore);
        $data['is_active'] = $request->has('is_active');

        // Auto-replace physical PDF file if new one uploaded
        if ($request->hasFile('pdf_file')) {
            if ($survei->pdf_file && Storage::disk('public')->exists($survei->pdf_file)) {
                Storage::disk('public')->delete($survei->pdf_file);
            }
            $path = $request->file('pdf_file')->store('survei', 'public');
            $data['pdf_file'] = $path;
        }

        $survei->update($data);

        ActivityLogger::log('UPDATE', 'Survei SKM', "Memperbarui data survei kepuasan ID #{$id}: {$survei->periode} (IKM: {$survei->ikm_score})");

        return back()->with('success', 'Data Hasil Survei Kepuasan Masyarakat (SKM) berhasil diperbarui.');
    }

    public function toggleActive($id)
    {
        $survei = SurveiKepuasan::findOrFail($id);
        $survei->is_active = !$survei->is_active;
        $survei->save();

        ActivityLogger::log('UPDATE', 'Survei SKM', "Mengubah status aktif survei ID #{$id} menjadi " . ($survei->is_active ? 'Aktif' : 'Non-aktif'));

        return back()->with('success', 'Status publikasi survei berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $survei = SurveiKepuasan::findOrFail($id);
        $periode = $survei->periode;

        if ($survei->pdf_file && Storage::disk('public')->exists($survei->pdf_file)) {
            Storage::disk('public')->delete($survei->pdf_file);
        }

        $survei->delete();

        ActivityLogger::log('DELETE', 'Survei SKM', "Menghapus data survei kepuasan: {$periode}");

        return back()->with('success', 'Data hasil survei berhasil dihapus.');
    }
}
