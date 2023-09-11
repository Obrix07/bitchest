<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cryptocurrency;
use App\Models\Cryptovalues;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function showDashboardData(Request $request)
    {
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $role = $user->role;
        $balance = $user->wallet_balance;

        // Récupérer les crypto-monnaies et leurs quantités associées à l'utilisateur
        $cryptos = $user->wallets()->with('cryptocurrency')->get()->map(function ($wallet) {
            $latest_value = DB::table('cryptovalues')
                ->where('cryptocurrency_id', $wallet->cryptocurrency_id)
                ->orderBy('value_date', 'desc')
                ->first()
                ->value;
            return [
                'name' => $wallet->cryptocurrency->name,
                'quantity' => $wallet->quantity,
                'latest_value' => $latest_value
            ];
        });

        // Récupérer les transactions de l'utilisateur
        $transactions = $user->transactions()->with('cryptocurrency')->get()->map(function ($transaction) {
            return [
                'name' => $transaction->cryptocurrency->name,
                'type' => $transaction->type,
                'quantity' => $transaction->quantity,
                'value_at_time' => $transaction->cryptovalue->value,
                'created_at' => $transaction->created_at
            ];
        });

        return response()->json(['balance' => $balance, 'role' => $role, 'cryptos' => $cryptos, 'transactions' => $transactions]);
    }

    public function getAllCryptos()
    {
        $cryptos = Cryptocurrency::select(
            'id',
            'name',
            'symbol',
            DB::raw("(SELECT value FROM cryptovalues WHERE cryptocurrencies.id = cryptovalues.cryptocurrency_id ORDER BY value_date DESC LIMIT 1) as latest_value")
        )->get();
        return response()->json($cryptos);
    }


    public function buyCrypto(Request $request)
    {
        $user = auth()->user();
        $cryptoId = $request->input('cryptoId');
        $quantity = $request->input('quantity');

        // Récupérez la dernière valeur de la crypto-monnaie
        $latestValue = DB::table('cryptovalues')
            ->where('cryptocurrency_id', $cryptoId)
            ->orderBy('value_date', 'desc')
            ->limit(1)
            ->first();

        if (!$latestValue) {
            return response()->json(['error' => 'Valeur de la crypto-monnaie introuvable'], 404);
        }

        // Calcul du coût total
        $totalCost = $latestValue->value * $quantity;

        if ($totalCost > $user->wallet_balance) {
            return response()->json(['error' => 'Solde insuffisant'], 400);
        }

        // Mettre à jour le solde de l'utilisateur
        $user->wallet_balance -= $totalCost;
        $user->save();

        // Mettre à jour ou créer le portefeuille crypto de l'utilisateur
        $wallet = Wallet::firstOrNew([
            'user_id' => $user->id,
            'cryptocurrency_id' => $cryptoId
        ]);
        $wallet->quantity += $quantity;
        $wallet->save();

        // Créer une nouvelle transaction
        $transaction = new Transaction([
            'user_id' => $user->id,
            'cryptocurrency_id' => $cryptoId,
            'cryptovalues_id' => $latestValue->id,
            'type' => 'buy',
            'quantity' => $quantity,
        ]);
        $transaction->save();

        return response()->json(['message' => 'Achat réussi']);
    }

    public function getProfile()
    {
        $client = auth()->user();
        return response()->json($client);
    }

    public function getWallet()
    {
        $userId = auth()->id();
        $wallet = Wallet::where('user_id', $userId)->with('cryptocurrency')->get();
        return response()->json($wallet);
    }

    public function sellCrypto(Request $request)
    {
        $user = auth()->user();
        $cryptoName = $request->input('name');

        // Trouver le portefeuille associé à cette crypto et à cet utilisateur
        $wallet = Wallet::where('user_id', $user->id)
            ->whereHas('cryptocurrency', function ($query) use ($cryptoName) {
                $query->where('name', $cryptoName);
            })
            ->firstOrFail();

        // Récupérez la dernière valeur de la crypto-monnaie
        $latestValue = DB::table('cryptovalues')
            ->where('cryptocurrency_id', $wallet->cryptocurrency_id)
            ->orderBy('value_date', 'desc')
            ->limit(1)
            ->first();

        // Calculer le revenu total de la vente
        $totalRevenue = $latestValue->value * $wallet->quantity;

        // Mettre à jour le solde de l'utilisateur
        $user->wallet_balance += $totalRevenue;
        $user->save();

        // Enregistrer la transaction
        $transaction = new Transaction([
            'user_id' => $user->id,
            'cryptocurrency_id' => $wallet->cryptocurrency_id,
            'cryptovalues_id' => $latestValue->id,
            'type' => 'sell',
            'quantity' => $wallet->quantity,
        ]);
        $transaction->save();

        // Supprimer ou mettre à jour le portefeuille
        $wallet->delete();

        return response()->json([
            'message' => 'Vente réussie',
            'balance' => $user->wallet_balance,
            // Autres données nécessaires
        ]);
    }

    public function getBuyingPrice($cryptoName)
    {
        $transaction = Transaction::where('cryptocurrency_id', Cryptocurrency::where('name', $cryptoName)->first()->id)
            ->first();
        $buyingPrice = Cryptovalues::find($transaction->cryptovalues_id)->value;

        return response()->json(['buyingPrice' => $buyingPrice]);
    }

    public function getCurrentPrice($cryptoName)
    {
        $currentPrice = Cryptovalues::where('cryptocurrency_id', Cryptocurrency::where('name', $cryptoName)->first()->id)
            ->orderBy('value_date', 'desc')
            ->first()
            ->value;

        return response()->json(['currentPrice' => $currentPrice]);
    }
}
