<?php

namespace App\Http\Controllers\Api\Donations;

use App\Http\Controllers\Controller;
use App\Models\DonationItemsCatalog;
use Illuminate\Http\Request;

class DonationItemsCatalogController extends Controller
{
    /**
     * Listar todos los items (JSON para el admin o front)
     */
    public function index()
    {
        return DonationItemsCatalog::with('shelter')->orderBy('id_donation_item_catalog', 'desc')->get();
    }

    /**
     * Crear un nuevo item en la BD
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_name'       => 'required|string|max:255',
            'category'        => 'required|string|max:255',
            'quantity_needed' => 'required|integer|min:1',
            'id_shelter'      => 'nullable|integer|exists:shelters,id_shelter',
            'description'     => 'nullable|string',
        ]);

        $item = DonationItemsCatalog::create($validatedData);

        return response()->json([
            'message' => 'Artículo creado exitosamente',
            'data' => $item
        ], 201);
    }

    /**
     * Mostrar un solo item
     */
    public function show($id)
    {
        $item = DonationItemsCatalog::find($id);
        if (!$item) {
            return response()->json(['message' => 'Artículo no encontrado'], 404);
        }
        return $item;
    }

    /**
     * Actualizar item en la BD
     */
    public function update(Request $request, $id)
    {
        $item = DonationItemsCatalog::find($id);
        if (!$item) {
            return response()->json(['message' => 'Artículo no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'item_name'       => 'required|string|max:255',
            'category'        => 'required|string|max:255',
            'quantity_needed' => 'required|integer|min:1',
            'id_shelter'      => 'nullable|integer|exists:shelters,id_shelter',
            'description'     => 'nullable|string',
        ]);

        $item->update($validatedData);

        return response()->json([
            'message' => 'Artículo actualizado',
            'data' => $item
        ]);
    }

    /**
     * Eliminar item de la BD
     */
    public function destroy($id)
    {
        $item = DonationItemsCatalog::find($id);
        if (!$item) {
            return response()->json(['message' => 'Artículo no encontrado'], 404);
        }

        $item->delete();
        return response()->json(['message' => 'Artículo eliminado'], 204);
    }
}