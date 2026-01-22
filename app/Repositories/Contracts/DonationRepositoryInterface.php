<?php

namespace App\Repositories\Contracts;

interface DonationRepositoryInterface {
    public function paginate($perPage = 20);
    public function findWithDetails($id);
}