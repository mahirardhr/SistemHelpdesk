<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Timeline;
use App\Mail\LaporanSelesaiMail as MailLapor;
use App\Mail\NotifikasiEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        //Update status menjadi expired untuk laporan open lebih dari 3 hari
        Laporan::where('status', 'open')
            ->where('created_at', '<=', Carbon::now()->subDays(3))
            ->update(['status' => 'expired']);


        // Mulai query laporan
        $query = Laporan::with(['pelapor', 'pic', 'kategori']);

        // Filter berdasarkan role user
        if ($user->role == 'krani') {
            $query->where('pic_id', $user->id);
        }
        if ($user->role == 'pelapor') {
            $query->where('pelapor_id', $user->id);
        }

        // Fitur pencarian nomor tiket
        if ($request->filled('search')) {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status (opsional dari dropdown)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting: Status (open, in_progress, closed), lalu tanggal (created_at desc)
        $query->orderByRaw("
    CASE status
        WHEN 'open' THEN 1
        WHEN 'expired' THEN 2
        WHEN 'in_progress' THEN 3
        WHEN 'closed' THEN 4
        ELSE 5
    END
")->orderBy('created_at', 'desc');


        // Paginate hasil
        $laporans = $query->paginate(10);

        // Tambahkan status SLA untuk masing-masing laporan
        foreach ($laporans as $laporan) {
            $laporan->status_sla = $this->hitungStatusSLA($laporan);
        }

        // Return ke view sesuai role
        if ($user->role === 'pelapor') {
            return view('pelapor.laporanPelapor', compact('laporans'));
        }

        return view('template.totalLaporan', compact('laporans'));
    }


    public function create()
    {
        $kategoris = Kategori::all(); // Ambil semua kategori
        return view('template.laporan_form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'email'       => 'required|email',
            // 'phone'       => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            // 'department'  => 'required',
            'description' => 'required',
            'attachment'  => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480',
        ]);

        $path = $request->file('attachment')->store('attachments', 'public');

        Laporan::create([
            'ticket_number' => 'TKT-' . strtoupper(Str::random(6)),
            // 'email'         => $request->email,
            // 'phone'         => $request->phone,
            'kategori_id'   => $request->kategori_id,
            // 'department'    => $request->department,
            'description'   => $request->description,
            'status'        => 'open',
            'pelapor_id'    => Auth::id(), // ambil dari user yang sedang login
            'attachment'    => $path,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $laporan = Laporan::with(['kategori', 'pelapor'])->findOrFail($id);

        // Ambil semua user yang bisa menjadi PIC (asisten TI dan krani)
        $listPIC = User::whereIn('role', ['krani', 'asisten'])->get();

        return view('template.laporan_edit', compact('laporan', 'listPIC'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'status'            => 'required|in:open,in_progress,closed',
            'pic_id'            => 'nullable|exists:users,id',
            'sla_close'         => 'nullable|date',
            'prioritas'         => 'nullable|in:rendah,sedang,tinggi',
            // 'catatan_selesai'   => 'nullable|string',
        ]);

        // Jika status baru adalah 'in_progress' dan sebelumnya belum di-set, isi tanggal_mulai
        if ($request->status === 'in_progress' && !$laporan->tanggal_mulai) {
            $laporan->tanggal_mulai = now();
        }

        // Tetap update kolom utama
        $laporan->status        = $request->status;
        $laporan->pic_id        = $request->pic_id;
        $laporan->sla_close     = $request->sla_close;
        $laporan->prioritas     = $request->prioritas;

        // // Selalu update catatan & checkbox KB jika status ditutup
        // if ($request->status === 'closed') {
        //     $laporan->catatan_selesai = $request->input('catatan_selesai');
        //     $laporan->tampilkan_di_kb = $request->has('tampilkan_di_kb') ? true : false;

        //     Mail::to($laporan->pelapor->email)->queue(new MailLapor($laporan));
        // } else {
        //     // Jika status bukan closed, pastikan flag KB diset ulang ke false
        //     $laporan->tampilkan_di_kb = false;
        // }
        //    dd($request->status);
        // if ($request->status === 'closed') {
        //     dd('Masuk sini',$laporan->pelapor->email);

        //     $laporan->catatan_selesai = $request->input('catatan_selesai');

        //     // Cek apakah kolom tampilkan_di_kb ada sebelum diakses
        //     if (Schema::hasColumn('laporans', 'tampilkan_di_kb')) {
        //         $laporan->tampilkan_di_kb = $request->has('tampilkan_di_kb');
        //     }
        //     try {

        //         Mail::to($laporan->pelapor->email)->send(new NotifikasiEmail($laporan));
        //         $laporan->save();
        //         return redirect()->route('laporan.index')->with('success', 'Status laporan berhasil diperbarui dan notifikasi email berhasil dikirim.');
        //     } catch (Exception $e) {
        //         $laporan->save();
        //         return redirect()->route('laporan.index')->with('warning', 'Status laporan berhasil diperbarui, tetapi email gagal dikirim. Error: ' . $e->getMessage());
        //     }
        // } else {
        // Reset tampilkan_di_kb jika kolomnya ada
        // if (Schema::hasColumn('laporans', 'tampilkan_di_kb')) {
        //     $laporan->tampilkan_di_kb = false;
        // }
        if (Schema::hasColumn('laporans', 'tampilkan_di_kb') && $request->status !== 'closed') {
            $laporan->tampilkan_di_kb = false;
        }
        $laporan->save();
        return redirect()->route('laporan.index')->with('success', 'Status laporan berhasil diperbarui.');
    }


    public function selesai(Request $request)
    {
        $user = Auth::user();

        $query = Laporan::with(['pelapor', 'pic', 'kategori'])
            ->where('status', 'closed');

        // Filter berdasarkan nomor tiket
        if ($request->filled('search')) {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        // Role-based filter
        if ($user->role === 'krani') {
            $query->where('pic_id', $user->id);
        }

        if ($user->role === 'pelapor') {
            $query->where('pelapor_id', $user->id);
        }

        // Filter berdasarkan PIC yang dipilih di dropdown (khusus asisten)
        $selectedPicId = $request->input('pic_id');
        if ($user->role === 'asisten' && !empty($selectedPicId)) {
            $query->where('pic_id', $selectedPicId);
        }

        // Ambil semua data
        $laporanSelesaiAll = $query->get();

        // Hitung SLA dan buat sort order
        foreach ($laporanSelesaiAll as $laporan) {
            $laporan->status_sla = $this->hitungStatusSLA($laporan);
            $laporan->sla_sort_order = match ($laporan->status_sla) {
                'Terlambat' => 1,
                'Melewati Batas Waktu' => 2,
                'Tepat Waktu' => 3,
                default => 4
            };
        }

        // Sort by SLA order
        $laporanSelesaiAll = $laporanSelesaiAll->sortBy('sla_sort_order');

        // Manual pagination
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $laporanSelesaiAll->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $laporanSelesai = new LengthAwarePaginator($currentItems, $laporanSelesaiAll->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query()
        ]);

        // Ambil semua pengguna ber-role krani dan asisten (untuk dropdown PIC)
        $daftarPic = User::whereIn('role', ['krani', 'asisten'])->get();

        return view('template.laporanSelesai', compact('laporanSelesai', 'daftarPic', 'selectedPicId'));
    }

    public function show($id)
    {
        $laporan = Laporan::with(['kategori', 'pelapor'])->findOrFail($id);
        return view('template.laporan_show', compact('laporan'));
    }

    // Contoh di controller
    public function antrian(Request $request)
    {
        $query = Laporan::with(['pelapor', 'kategori'])
            ->where('status', 'open');

        // Cek apakah ada input pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        $laporans = $query->latest()->get();

        return view('template.antrian', compact('laporans'));
    }

    public function diproses(Request $request)
    {
        $user = Auth::user();

        $query = Laporan::with(['pelapor', 'pic', 'kategori'])
            ->where('status', 'in_progress');

        // Jika user adalah krani, hanya tampilkan laporan yang menjadi tanggung jawabnya
        if ($user->role == 'krani') {
            $query->where('pic_id', $user->id);
        }
        if ($user->role == 'pelapor') {
            $query->where('pelapor_id', $user->id);
        }
        if ($request->has('search') && $request->search != '') {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        $laporans = $query->latest()->paginate(10);

        // Tambahkan logika SLA ke setiap laporan
        foreach ($laporans as $laporan) {
            $laporan->status_sla = $this->hitungStatusSLA($laporan);
        }

        return view('template.diproses', compact('laporans'));
    }
    public function close(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status = 'closed';
        $laporan->catatan_selesai = $request->catatan_selesai;
        $laporan->tanggal_selesai = now(); // ✅ ini baris tambahan penting
        $laporan->save();

        return redirect()->back()->with('success', 'Laporan berhasil ditutup dengan catatan.');
    }
    public function updateCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan_selesai' => 'required|string',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->catatan_selesai = $request->catatan_selesai;
        $laporan->status = 'closed';
        $laporan->tanggal_selesai = now(); // ✅ tambahkan ini juga
        $laporan->tampilkan_di_kb = $request->has('tampilkan_di_kb') ? 1 : 0;
        $laporan->save();

        try {
            Mail::to($laporan->pelapor->email)->send(new NotifikasiEmail($laporan));

            $laporan->save();
            return redirect()->route('laporan.index')->with('success', 'Laporan ditutup dan email notifikasi berhasil dikirim.');
        } catch (Exception $e) {
            $laporan->save();
            return redirect()->route('laporan.index')->with('success', 'Laporan ditutup dengan catatan.');
        }
    }
    public function timeline($id)
    {
        $laporan = Laporan::findOrFail($id);

        return response()->json([
            'created_at'      => $laporan->created_at,
            'tanggal_mulai'   => $laporan->tanggal_mulai,
            'tanggal_selesai' => $laporan->tanggal_selesai,  // waktu laporan selesai/close
            'nama_pic' => $laporan->pic->name ?? null,
            'catatan_selesai' => $laporan->catatan_selesai ?? null,
        ]);
    }

    // LaporanController.php

    public function respon($id)
    {
        $user = request()->user(); // Ini tetap lebih clean daripada auth()->user()
        $laporan = Laporan::findOrFail($id);

        // Pastikan hanya pelapor asli yang bisa konfirmasi laporannya
        if ($user->role !== 'pelapor' || $laporan->pelapor_id !== $user->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $laporan->user_confirmed = true;
        $laporan->save();

        return back()->with('success', 'Laporan telah dikonfirmasi selesai.');
    }
    public function riwayat(Request $request)
    {
        $user = Auth::user();

        // Ambil laporan milik pelapor
        $query = Laporan::with(['pelapor', 'pic', 'kategori'])
            ->where('pelapor_id', $user->id);

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        $laporans = $query->latest()->paginate(10);

        // Tambahkan logika SLA ke setiap laporan
        foreach ($laporans as $laporan) {
            $laporan->status_sla = $this->hitungStatusSLA($laporan);
        }
        return view('pelapor.riwayat', compact('laporans'));
    }
    public function ratingForm($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('pelapor.rating', compact('laporan'));
    }

    public function submitRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->rating = $request->rating;
        $laporan->user_confirmed = true;
        $laporan->save();

        return redirect()->route('pelapor.riwayat')->with('success', 'Terima kasih atas penilaian Anda.');
    }
    private function hitungStatusSLA($laporan)
    {
        // Pastikan SLA dan tanggal selesai tersedia
        if ($laporan->sla_close) {
            $batasSLA = \Carbon\Carbon::parse($laporan->sla_close)->toDateString();

            // Jika sudah selesai
            if ($laporan->tanggal_selesai) {
                $selesai = \Carbon\Carbon::parse($laporan->tanggal_selesai)->toDateString();
                return $selesai <= $batasSLA ? 'Tepat Waktu' : 'Terlambat';
            }

            // Jika belum selesai tapi sudah lewat SLA
            if (now()->greaterThan($batasSLA)) {
                return 'Melewati Batas Waktu';
            }

            // Masih dalam proses dan masih dalam waktu SLA
            return 'Dalam Proses';
        }

        return 'Tidak Ditentukan';
    }

    public function knowledgeBase(Request $request)
    {
        $query = Laporan::with('kategori')
            ->where('status', 'closed')
            ->whereNotNull('catatan_selesai')
            ->where('tampilkan_di_kb', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($qKategori) use ($search) {
                        // Ganti 'nama' sesuai nama kolom sebenarnya
                        $qKategori->where('nama_kategori', 'like', "%{$search}%");
                    });
            });
        }

        $laporans = $query->latest()->paginate(10);
        return view('template.knowledge_base', compact('laporans'));
    }


    public function exportRekapSLA(Request $request)
    {
        $user = Auth::user();
        $start = $request->start;
        $end = $request->end;

        $query = Laporan::with(['kategori', 'pelapor.departemen', 'pic'])
            ->whereBetween('created_at', [$start, $end]);

        // 🔐 Filter berdasarkan role user login
        if ($user->role === 'krani' || $user->role === 'pic') {
            $query->where('pic_id', $user->id);
        }

        $laporans = $query->get();

        foreach ($laporans as $laporan) {
            $laporan->sla_status = $this->hitungStatusSLA($laporan);
        }

        $pdf = PDF::loadView('laporan.sla-rekap-pdf', compact('laporans', 'start', 'end', 'user'));
        return $pdf->download("Rekap-SLA-$start-sampai-$end.pdf");
    }
}
