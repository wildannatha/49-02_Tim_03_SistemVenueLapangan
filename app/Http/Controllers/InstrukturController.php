<?php

namespace App\Http\Controllers;

use App\Models\Instruktur;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstrukturController extends Controller
{
    private array $cabangOptions = ['Badminton', 'Futsal', 'Basket', 'Tenis', 'Voli'];

    private function rules($id = null): array
    {
        return [
            'nama' => 'required|max:100',
            'nomor_lisensi' => ['required', 'max:50', Rule::unique('instruktur', 'nomor_lisensi')->ignore($id)],
            'level_sertifikasi' => 'required|in:Daerah,Nasional,Internasional',
            'cabang' => 'required|array|min:1',
            'cabang.*' => Rule::in($this->cabangOptions),
            'telepon' => 'required|max:20',
            'tarif' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
            'tanggal_gabung' => 'nullable|date',
            'catatan' => 'nullable|string',
        ];
    }

    private function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nomor_lisensi.required' => 'Nomor lisensi wajib diisi.',
            'nomor_lisensi.unique' => 'Nomor lisensi sudah terdaftar untuk instruktur lain.',
            'level_sertifikasi.required' => 'Pilih level sertifikasi.',
            'cabang.required' => 'Pilih minimal satu cabang olahraga.',
            'cabang.min' => 'Pilih minimal satu cabang olahraga.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'tarif.required' => 'Masukkan tarif yang valid.',
            'tarif.integer' => 'Masukkan tarif yang valid.',
            'tarif.min' => 'Masukkan tarif yang valid.',
        ];
    }

    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $cabang = $request->query('cabang', '');
        $status = $request->query('status', '');

        $instruktur = Instruktur::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nama', 'like', "%$q%")
                      ->orWhere('nomor_lisensi', 'like', "%$q%")
                      ->orWhere('telepon', 'like', "%$q%");
                });
            })
            ->when($cabang !== '', fn ($query) => $query->where('cabang', 'like', "%$cabang%"))
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->orderByDesc('id')
            ->get();

        return view('instruktur.index', [
            'instruktur' => $instruktur,
            'cabangOptions' => $this->cabangOptions,
            'q' => $q,
            'cabang' => $cabang,
            'status' => $status,
        ]);
    }

    public function create()
    {
        return view('instruktur.form', ['cabangOptions' => $this->cabangOptions]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());
        $data['cabang'] = implode(', ', $data['cabang']);
        Instruktur::create($data);

        return redirect()->route('instruktur.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Instruktur $instruktur)
    {
        return view('instruktur.form', [
            'instruktur' => $instruktur,
            'cabangOptions' => $this->cabangOptions,
        ]);
    }

    public function update(Request $request, Instruktur $instruktur)
    {
        $data = $request->validate($this->rules($instruktur->id), $this->messages());
        $data['cabang'] = implode(', ', $data['cabang']);
        $instruktur->update($data);

        return redirect()->route('instruktur.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Instruktur $instruktur)
    {
        $instruktur->delete();

        return redirect()->route('instruktur.index')->with('success', 'Data berhasil dihapus.');
    }
}