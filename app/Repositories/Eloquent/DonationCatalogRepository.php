<?php

namespace App\Repositories\Eloquent;

use App\Models\DonationItemsCatalog;
use App\Repositories\Contracts\DonationCatalogRepositoryInterface;

class DonationCatalogRepository implements DonationCatalogRepositoryInterface {
    public function all() {
        return DonationItemsCatalog::with('shelter')->orderBy('id_donation_item_catalog', 'desc')->get();
    }
    public function find($id) {
        return DonationItemsCatalog::findOrFail($id);
    }
    public function create(array $data) {
        return DonationItemsCatalog::create($data);
    }
    public function update($id, array $data) {
        $item = $this->find($id);
        $item->update($data);
        return $item;
    }
    public function delete($id) {
        return DonationItemsCatalog::destroy($id);
    }
}