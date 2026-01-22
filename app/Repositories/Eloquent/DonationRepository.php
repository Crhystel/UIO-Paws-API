<?php

namespace App\Repositories\Eloquent;

use App\Models\Donation;
use App\Repositories\Contracts\DonationRepositoryInterface;

class DonationRepository implements DonationRepositoryInterface {
    public function paginate($perPage = 20) {
        return Donation::with('user')->latest('donation_date')->paginate($perPage);
    }
    public function findWithDetails($id) {
        return Donation::with(['user', 'items.catalogItem'])->findOrFail($id);
    }
}