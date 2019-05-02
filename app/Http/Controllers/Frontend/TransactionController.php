<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\WalletRequest;
use App\Http\Requests\PerdayRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class TransactionController extends Controller
{
    /**
     * repository
     */
    protected $user;
    protected $wallet;
    protected $transaction;
    protected $category;

    public function __construct(UserRepositoryInterface $user, WalletRepositoryInterface $wallet, 
                                TransactionRepositoryInterface $transaction, CategoryRepositoryInterface $category)
    {
        $this->user = $user;
        $this->wallet = $wallet;
        $this->transaction = $transaction;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = $this->transaction->getTransactionUser(Auth::id());
        $categoryTransactions = $this->transaction->getTransactionCategory(Auth::id());
        $moneyTransactions = $this->transaction->getTransferUser(Auth::id());
        $categories = $this->category->getRootCatgory(Auth::id());
        return view('transactions.index', [
            'transactions' => $transactions, 
            'categoryTransactions' => $categoryTransactions,
            'moneyTransactions' => $moneyTransactions, 
            'categories' => $categories
         ]);
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

    public function showPerDay(Request $req)
    {   
        $rules = [
            'type' =>'required',
            'start_date' => 'required|date|before:today',
            'end_date' => 'required|date|after:start_date|before:tomorrow',
        ];
        $messages = [
            'start_date.required'=> 'Ngày bắt đầu là bắt buộc',
            'start_date.before'=> 'Ngày bắt đầu phải trước ngày hôm nay',
            'end_date.before'=> 'Ngày kết thúc không quá ngày hôm nay',
            'end_date.after' => 'Ngày kết thúc là sau ngày bắt đầu',
            'end_date.required' => 'Ngày kết thúc là trường bắt buộc',           
            'type.required' => 'Chọn loại lọc (theo ngày/theo tháng)',
        ];
        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        } else {
            $data = $this->transaction->getAllByDay($req, Auth::id());
            return  response()->json($data);
        }
    }

    public function showPerMonth(Request $req)
    {
        $rules = [
            'type' =>'required',
            'start_month' => 'required',
            'end_month' => 'required',
            'te' => 'after:ts'
        ];
        $messages = [
            'start_month.required'=> 'Tháng bắt đầu là bắt buộc',
            'end_month.required' => 'Tháng kết thúc là bắt buộc',           
            'type.required' => 'Chọn loại lọc (theo ngày/theo tháng)',
            'te.after' =>'Tháng kết thúc phải sau tháng bắt đầu'
        ];
         $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        } else {
            $data = $this->transaction->getAllByMonth($req, Auth::id());
            return  response()->json($data);
        }
    }

    public function excel(Request $req)
    {
        return Excel::download(new TransactionExport, 'data.xlsx');
    }
}
