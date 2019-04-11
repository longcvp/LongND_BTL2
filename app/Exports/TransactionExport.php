<?php

namespace App\Exports;

use Auth;
use Carbon\Carbon;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		return Transaction::where('user_id', Auth::id())
           	->where('created_at', '>', Carbon::now()->subDays(30))
           	->where('created_at', '<=', Carbon::now())
           	->get();
    }

    public function map($transaction): array
    {
        return [
            ($transaction->type == TRANSFER) ? 'Chuyển tiền' : (($transaction->type == PAY) ? 'Thanh toán chi tiêu' : 'Nhận tiền'),
            ($transaction->type == TRANSFER) ? 'Không có' : $transaction->category->name.'-'.$transaction->category->nameParent->name,
            ($transaction->type == RECEIVE) ? 'Không có' : $transaction->fromWallet->name.'-'.$transaction->fromWallet->user->infomation->name,
            ($transaction->type == PAY) ? 'Không có' : $transaction->toWallet->name.'-'.$transaction->toWallet->user->infomation->name,
            (number_format($transaction->money). ' vnđ'),
            date('d-m-Y H:i:s', strtotime($transaction->updated_at)),
        ];
    }

    public function headings(): array
    {
        return [
            'Thể loại giao dịch',
            'Tên danh mục thu/chi',
            'Ví chuyển tiền',
            'Ví nhận tiền',
            'Số tiền giao dịch',
            'Ngày giao dịch'
        ];
    }
}
