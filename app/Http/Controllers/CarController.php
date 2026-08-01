<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('merek', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('available') && $request->available == '1') {
            $query->whereDoesntHave('rentals', function($q) {
                $q->where('status', 'rented');
            });
        }

        $cars = $query->get();
        return view('cars.index', compact('cars'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'merek' => 'required|string',
            'model' => 'required|string',
            'nomor_plat' => 'required|string|unique:cars',
            'tarif_per_hari' => 'required|numeric|min:0',
        ]);

        Car::create($request->all());

        return redirect()->route('cars.index')->with('success', 'Data mobil berhasil ditambahkan.');
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'merek' => 'required|string',
            'model' => 'required|string',
            'nomor_plat' => 'required|string|unique:cars,nomor_plat,' . $car->id,
            'tarif_per_hari' => 'required|numeric|min:0',
        ]);

        $car->update($request->all());

        return redirect()->route('cars.index')->with('success', 'Data mobil berhasil diperbarui.');
    }

    public function destroy(Car $car)
    {
        if ($car->rentals()->where('status', 'rented')->exists()) {
            return back()->withErrors(['car' => 'Mobil tidak dapat dihapus karena sedang dalam masa penyewaan!']);
        }

        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Data mobil berhasil dihapus.');
    }
}