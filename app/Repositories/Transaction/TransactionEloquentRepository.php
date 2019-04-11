<?php
namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repositories\EloquentRepository;



class TransactionEloquentRepository extends EloquentRepository implements TransactionRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Transaction::class;
    }

    public function createTransfer($data, $toWalletId = 0)
    {
    	return $this->_model->createTransfer($data, $toWalletId);
    }

    public function getTransactionUser($userId)
    {
        return $this->_model->getDataTransaction($userId);
    }

    public function getTransactionCategory($userId)
    {
        return $this->_model->getTransactionCategory($userId);
    }

    public function getTransferUser($userId)
    {
        return $this->_model->getTransfer($userId);
    }

    public function getAllByDay($data, $userId)
    {
        $startDay = $data->start_date;
        $finishDay = $data->end_date;

        $start = Carbon::parse($startDay);
        $end = Carbon::parse($finishDay);
        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->copy();
            $start->addDay();
        }
        $response = array();
        foreach ($dates as  $date) {
            $startDate = $date->copy();
            $afterDate = $date->addDay();
            $dataByDay = $this->_model->getDataByDay($startDate, $afterDate, $userId);
            $response = array_merge($response, $this->getResponseData($dataByDay, $startDate, 'd-m-Y'));
        } 
        return $response;
    }
    public function getAllByMonth($data, $userId)
    {
        $startMonth = $data->start_month;
        $finishMonth = $data->end_month;
        $start = Carbon::parse($startMonth);
        $end = Carbon::parse($finishMonth);
        $dates = array();
        while ($start->lte($end)) {
            $dates[] = $start->format('Y-m');
            $start->addMonth();
        }
        $response = array();

        foreach ($dates as  $date) {
                $month = date('m',strtotime($date));
                $year = date('Y',strtotime($date));
                $dataByMonth = $this->_model->getDataByMonth($month, $year, $userId);
                $response = array_merge($response, $this->getResponseData($dataByMonth, $date, 'm-Y'));
            }
        return $response;
    }

    public function getResponseData($data, $startDate, $type)
    {
        $response = array();
        foreach ($data as $key => $val) {
            $response[date($type, strtotime($startDate))][$key]['FROM'] = ($val->from_wallet_id == 0) ? 
                    'Thu cho '.$val->category->name.' từ '.$val->category->nameParent->name : 
                    $val->fromWallet->name;
            $response[date($type, strtotime($startDate))][$key]['TO'] = ($val->to_wallet_id == 0) ? 
                            'Chi cho '.$val->category->name.' từ '.$val->category->nameParent->name : 
                            $val->toWallet->name;
            $response[date($type, strtotime($startDate))][$key]['MONEY'] = number_format($val->money).' vnđ';
            $response[date($type, strtotime($startDate))][$key]['DAY'] = date('d-m-Y', strtotime($val->updated_at));
        }

        return $response;        
    }
}