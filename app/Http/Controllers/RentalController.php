<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('car')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        $rentedCarIds = Rental::where('status', 'rented')->pluck('car_id');
        $cars = Car::whereNotIn('id', $rentedCarIds)->get();

        return view('rentals.create', compact('cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'car_id.required' => 'Silakan pilih mobil yang ingin disewa.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh lewat dari hari ini.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);
        $isRented = Rental::where('car_id', $request->car_id)
            ->where('status', 'rented')
            ->exists();

        if ($isRented) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['car_id' => 'Maaf, mobil ini sedang disewa oleh pengguna lain.']);
        }

        Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'rented',
            'total_cost' => 0, 
        ]);

        return redirect()->route('rentals.index')
            ->with('success', 'Berhasil melakukan pemesanan sewa mobil.');
    }

    public function showReturnForm()
    {
        return view('rentals.return');
    }

    public function processReturn(Request $request)
    {
        $request->validate([
            'nomor_plat' => 'required|string',
        ], [
            'nomor_plat.required' => 'Nomor plat mobil wajib diisi.',
        ]);

        $nomorPlat = strtoupper(trim($request->nomor_plat));
        $car = Car::where('nomor_plat', $nomorPlat)->first();
        if (!$car) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nomor_plat' => 'Mobil dengan nomor plat tersebut tidak ditemukan dalam sistem.']);
        }
        $rental = Rental::where('car_id', $car->id)
            ->where('user_id', Auth::id())
            ->where('status', 'rented')
            ->first();

        if (!$rental) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nomor_plat' => 'Anda tidak sedang menyewa mobil dengan nomor plat tersebut.']);
        }
        $startDate = Carbon::parse($rental->start_date);
        $endDate = Carbon::parse($rental->end_date);
        
        $durasiHari = $startDate->diffInDays($endDate);
        if ($durasiHari == 0) {
            $durasiHari = 1;
        }

        $tarifPerHari = $car->tarif_per_hari;
        $totalBiaya = $durasiHari * $tarifPerHari;

        $rental->update([
            'status' => 'returned',
            'total_cost' => $totalBiaya,
            'returned_at' => now(),
        ]);
        
        $pesan = sprintf(
            'Mobil %s (%s) berhasil dikembalikan. Durasi sewa: %d hari. Total biaya sewa: Rp %s.',
            $car->merek . ' ' . $car->model,
            $car->nomor_plat,
            $durasiHari,
            number_format($totalBiaya, 0, ',', '.')
        );

        return redirect()->route('rentals.index')->with('success', $pesan);
    }
}