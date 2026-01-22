<?php
namespace App\Http\Controllers\Api\Donations;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\DonationCatalogRepositoryInterface;
use App\Http\Requests\Donations\DonationCatalogRequest;

class DonationItemsCatalogController extends Controller {
    protected $catalogRepo;

    public function __construct(DonationCatalogRepositoryInterface $catalogRepo) {
        $this->catalogRepo = $catalogRepo;
    }

    public function index() {
        return response()->json($this->catalogRepo->all());
    }

    public function store(DonationCatalogRequest $request) {
        $item = $this->catalogRepo->create($request->validated());
        return response()->json([
            'message' => 'Artículo creado exitosamente',
            'data' => $item
        ], 201);
    }

    public function show($id) {
        return response()->json($this->catalogRepo->find($id));
    }

    public function update(DonationCatalogRequest $request, $id) {
        $item = $this->catalogRepo->update($id, $request->validated());
        return response()->json([
            'message' => 'Artículo actualizado',
            'data' => $item
        ]);
    }

    public function destroy($id) {
        $this->catalogRepo->delete($id);
        return response()->json(['message' => 'Artículo eliminado'], 204);
    }
}