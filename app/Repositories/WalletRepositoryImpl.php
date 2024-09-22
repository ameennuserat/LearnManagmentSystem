<?php

namespace App\Repositories;

use App\Interfaces\WalletRepository;
use App\Models\Wallet;

class WalletRepositoryImpl implements WalletRepository
{
    public function getAllWallets()
    {
        return Wallet::getAll();
    }

    public function getWalletById($walletId)
    {
        return Wallet::findOrFail($walletId);
    }

    public function deleteWallet($walletId)
    {
        Wallet::destroy($walletId);
    }

    public function createWallet(array $walletDetails)
    {
        return Wallet::create($walletDetails);
    }

    public function updateWallet($walletId, array $newDetails)
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->update($newDetails);
        return $wallet;
    }
}
