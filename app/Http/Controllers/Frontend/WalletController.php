<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\WalletRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;


class WalletController extends Controller
{
    /**
        repository
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
        $wallets = $this->wallet->getWalletUser(Auth::id());
        return view('wallets.index', ['wallets' => $wallets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletRequest $req)
    {
        $this->wallet->saveWallet($req);
        return redirect()->route('wallets.index')->with('success', 'Tạo ví thành công');
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
        $wallet = $this->wallet->getWalletById($id);
        if ($wallet->user_id != Auth::id()) {
           return redirect()->back();
        } else {
           return view('wallets.edit', ['wallet' => $wallet]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WalletRequest $req, $id)
    {
        $this->wallet->updateInfoWallet($req);
        return redirect()->route('wallets.index')->with('success', 'Thay đổi thông tin ví thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wallet = $this->wallet->getWalletById($id);
        if ($wallet->user_id != Auth::id()) {
           return redirect()->back();
        } else {
            $this->wallet->deleteWallet($id);
            return redirect()->route('wallets.index')->with('success', 'Xóa thành công');
        }

    }

    public function getTransfer($type)
    {
        $wallets = $this->wallet->getWalletUser(Auth::id());
        if ($type == IN) {
            return view('wallets.transfer', ['wallets' => $wallets]);
        } else {
            return view('wallets.transfer_out', ['wallets' => $wallets]);
        }
    }

    public function postTransfer(TransferRequest $req)
    {
        $toWalletId = $this->wallet->updateMoneyTransfer($req);
        $this->transaction->createTransfer($req, $toWalletId);
        return redirect()->route('transactions.index')->with('success', 'Giao dịch thành công');
    }

    public function changeTransfer(Request $req)
    {
        $wallets = $this->wallet->changeTransferWallet($req);
        return response()->json($wallets)
                         ->header('Content-Type', 'JSON');
    }

    public function change()
    {
        return 1;
    }

    public function add()
    {
        echo "dsdsd";
    }
}
