<?php

namespace App\Interfaces;

interface WalletRepository
{
    public function getAllWallets();
    public function getWalletById($walletId);
    public function deleteWallet($valletId);
    public function createWallet(array $walletDetails);
    public function updateWallet($walletId, array $newDetails);
}
