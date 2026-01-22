<?php
namespace App\Http\Controllers\Api\Donations;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\DonationRepositoryInterface;
use App\Models\Donation;

class DonationController extends Controller {
    protected $donationRepo;

    public function __construct(DonationRepositoryInterface $donationRepo) {
        $this->donationRepo = $donationRepo;
    }

    public function index() {
        return response()->json($this->donationRepo->paginate(20));
    }

    public function show(Donation $donation) {
        return response()->json($this->donationRepo->findWithDetails($donation->id_donation));
    }
}