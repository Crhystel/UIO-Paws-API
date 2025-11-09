<?php

namespace App\Http\Controllers\Api\Donations;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(){
    return Donation::with('user')->latest('donation_date')->paginate(20);
    }
    public function show(Donation $donation) {
    return $donation->load(['user', 'items.catalogItem']);
    }
}
