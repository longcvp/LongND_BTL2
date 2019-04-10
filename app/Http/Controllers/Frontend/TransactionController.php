<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\WalletRequest;
use App\Http\Requests\TransactionRequest;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;

class TransactionController extends Controller
{
    /**
     * repository
     */
    protected $user;
    protected $wallet;
    protected $transaction;


    public function __construct(UserRepositoryInterface $user, WalletRepositoryInterface $wallet, 
                                TransactionRepositoryInterface $transaction)
    {
        $this->user = $user;
        $this->wallet = $wallet;
        $this->transaction = $transaction;
    }  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = $this->transaction->getTransactionUser(Auth::id());
        return view('transactions.index', ['transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $wallets = $this->wallet->getWalletUser(Auth::id());
        return view('transactions.create', ['wallets' => $wallets]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $this->wallet->updateMoneyTransaction($request);
        $this->transaction->createTransfer($request);
        return redirect()->route('transactions.index')->with('success', 'Giao dịch thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = $this->transaction->find($id);
        if ($transaction->user_id != Auth::id()) {
           return redirect()->back();
        } else {
            $this->transaction->find($id)->delete();
            return redirect()->route('transactions.index')->with('success', 'Xóa giao dịch thành công');
        }
    }
}
