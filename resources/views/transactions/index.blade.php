@extends('_layout.layout')
@section('title')
Quản lý các giao dịch cá nhân
@endsection
@section('content')
<div class="conten-wrapper">
    <section class="content container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
              <p>{{ session('success') }}</p>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
              <p>{{ session('error') }}</p>
        </div>
        @endif
    	<div class="container">
    		<h2>Quản lý các giao dịch của {{ Auth::user()->infomation->name }}</h2>
			<hr>
			<a href="{{ route('transactions.create') }}" type="button" class="btn btn-primary">Thanh toán Thu/Chi</a>
            <a href="{{ route('wallets.transfer', IN ) }}" type="button" class="btn btn-success" ><span class="glyphicon glyphicon-share-alt"></span>Chuyển tiền nội bộ</a>
            <a href="{{ route('wallets.transfer', OUT ) }}" type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-share-alt"></span>Chuyển tiền ra ngoài</a>
			<hr>
            <div class="row">
            	@if(count($transactions) != 0)
                <table id="table1" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thể loại giao dịch </th>
                            <th>Danh mục thu/chi</th>
                            <th>Ví chuyển tiền đi</th>
                            <th>Ví nhận tiền</th>
                            <th>Số tiền giao dịch</th>
                            <th>Ngày giao dịch</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $key => $transaction)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ ($transaction->type == TRANSFER) ? 'Chuyển tiền' : (($transaction->type == PAY) ? 'Thanh toán chi tiêu' : 'Nhận tiền') }}</td>
                                <td>{{ ($transaction->type == TRANSFER) ? 'Không có' : $transaction->category->name.'-'.$transaction->category->nameParent->name }}</td>
                                <td>{{ ($transaction->type == RECEIVE) ? 'Không có' : $transaction->fromWallet->name.'-'.$transaction->fromWallet->user->infomation->name }}</td>
                                <td>{{ ($transaction->type == PAY) ? 'Không có' : $transaction->toWallet->name.'-'.$transaction->toWallet->user->infomation->name }}</td>
                                <td>{{ number_format($transaction->money). ' vnđ' }}</td>
                                <td>{{ date('d-m-Y', strtotime($transaction->updated_at)) }}</td>
                                <td><form action="{{ route('transactions.destroy', $transaction->id )}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type='submit' onclick="confirm_delete();" class="btn btn-danger" value="Xóa">
                            </form>
                        </td>
                            </tr>  
                        @endforeach

                    </tbody>
                </table>    
                {{ $transactions->links() }}
                @else
                <p>Không có thông tin danh mục</p>
                @endif
            </div>
    	</div>
    </section>
</div>
@endsection

@section('css')

@endsection

@section('js')
<script type="text/javascript">
    function confirm_delete()
    {
        if(!confirm("Bạn chắc chắn muốn xóa giao dịch này"))
          event.preventDefault();            
    }

    
</script>
@endsection