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
            <div class="form-group">
    			<a href="{{ route('transactions.create') }}" type="button" class="btn btn-primary">Thanh toán Thu/Chi</a>
                <a href="{{ route('wallets.transfer', IN ) }}" type="button" class="btn btn-success" ><span class="glyphicon glyphicon-share-alt"></span>Chuyển tiền nội bộ</a>
                <a href="{{ route('wallets.transfer', OUT ) }}" type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-share-alt"></span>Chuyển tiền ra ngoài</a>
            </div>
			<hr>
            <form class="form-horizontal" method="POST" action="{{ route('transactions.excel') }}" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                <div class="form-group" id="root_category">
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-danger" name="out" value="Xuất file excel">
                    </div>
                </div>

            </form>
            <hr>
            <h3 >Danh mục giao dịch</h3>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" href="#review" role="tab" data-toggle="tab">Tổng quan giao dịch</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#category" role="tab" data-toggle="tab">Giao dịch theo danh mục</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#transfer" role="tab" data-toggle="tab">Các giao dịch chuyển tiền</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#time" role="tab" data-toggle="tab">Giao dịch theo thời gian</a>
              </li>
            </ul>
            <hr>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="review">
                    <div class="row">
                	@if(count($transactions) != 0)
                        <h3>Tổng quan giao dịch</h3>
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
                                        <td>{{ date('d-m-Y H:i:s', strtotime($transaction->updated_at)) }}</td>
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
                        <p>Không có thông tin giao dịch</p>
                    @endif
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="category">
                    <div class="row">
                    @if(count($categoryTransactions) != 0)
                        <h3>Danh sách giao dịch theo danh mục</h3>
                        <table id="table1" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Loại danh mục</th>
                                    <th>Tên danh mục</th>
                                    <th>Tên danh mục cha</th>
                                    <th>Ví chuyển tiền</th>
                                    <th>Ví nhận tiền</th>
                                    <th>Số tiền giao dịch</th>
                                    <th>Ngày giao dịch</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoryTransactions as $key => $transaction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ ($transaction->type == PAY) ? 'Danh mục chi' : 'Danh mục tiêu' }}</td>
                                        <td>{{ $transaction->category->name }}</td>
                                        <td>{{ $transaction->category->nameParent->name }}</td>
                                        <td>{{ ($transaction->type == RECEIVE) ? 'Không có' : $transaction->fromWallet->name.'-'.$transaction->fromWallet->user->infomation->name }}</td>
                                        <td>{{ ($transaction->type == PAY) ? 'Không có' : $transaction->toWallet->name.'-'.$transaction->toWallet->user->infomation->name }}</td>
                                        <td>{{ number_format($transaction->money). ' vnđ' }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($transaction->updated_at)) }}</td>
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
                    {{ $categoryTransactions->links() }}
                    @else
                        <p>Không có thông tin giao dịch</p>
                    @endif
                    </div>                    
                </div>
                <div role="tabpanel" class="tab-pane fade" id="transfer">
                    <div class="row">
                    @if(count($moneyTransactions) != 0)
                        <h3>Danh sách các giao dịch chuyển tiền</h3>
                        <table id="table1" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Loại chuyển tiền</th>
                                    <th>Ví chuyển tiền</th>
                                    <th>Người chuyển tiền</th>
                                    <th>Ví nhận tiền</th>
                                    <th>Người nhận chuyển tiền</th>
                                    <th>Số tiền giao dịch</th>
                                    <th>Ngày giao dịch</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moneyTransactions as $key => $transaction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ ($transaction->fromWallet->user->email === $transaction->toWallet->user->email) ? 'Chuyển tiền nội bộ' : 'Chuyển tiền bên ngoài' }}</td>
                                        <td>{{ $transaction->fromWallet->name }}
                                        <td>{{ $transaction->fromWallet->user->infomation->name }}</td>
                                        <td>{{ $transaction->toWallet->name }}
                                        <td>{{ $transaction->toWallet->user->infomation->name }}</td>
                                        <td>{{ number_format($transaction->money). ' vnđ' }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($transaction->updated_at)) }}</td>
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
                    {{ $moneyTransactions->links() }}
                    @else
                        <p>Không có thông tin giao dịch</p>
                    @endif
                    </div>                     
                </div>
                <div role="tabpanel" class="tab-pane fade" id="time">
                <section>
                    <h3>Giao dịch theo thời gian</h3>
                    <hr>
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="row" style="padding-left: 50px;">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <select class="selectpicker form-control" name="type">
                            <option selected hidden >Chọn loại lọc</option>
                            <option value="1">Theo ngày</option>
                            <option value="2">Theo tháng</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                            <button class="btn btn-danger" id="search">Thống kê</button>                    
                        </div>
                      </div>
                    </div>
                    <div class="row order-day" style="padding-left: 50px; display:none;">
                        <div class="col-sm-3">
                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-12 col-form-label">Ngày bắt đầu</label>
                              <div class='input-group' id='start_date'>
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                                  <input type="date" id="public_date" class="form-control" name="start_date" value=""/>
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Ngày kết thúc</label>
                                <div class='input-group' id='end_date'>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    <input type="date" id="end_public_date" class="form-control" name="end_date" value=""/>
                                </div>
                            </div>
                          </div>                
                    </div>
                    <div class="row order-month" style="padding-left: 50px; display:none;">
                        <div class="col-sm-3">
                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-12 col-form-label">Tháng bắt đầu</label>
                              <div class='input-group' id='start_date'>
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                                  <input type="month" id="start_month" class="form-control" name="start_month" min="2018-03">
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Tháng kết thúc</label>
                                <div class='input-group' id='end_date'>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                   <input type="month" id="end" class="form-control" name="end_month" min="2018-03">
                                </div>
                            </div>
                          </div>                
                    </div>
                </section>
                <hr>
                <section>
                    <div style="overflow-x:auto;" id="show-table">
                    </div>
                </section>                      
                </div>                
            </div>
    	</div>
    </section>
</div>
@endsection

@section('css')
<style type="text/css">
    table th, table td {
    font-family: inherit;
    font-size: inherit;
    padding: 12px;
    vertical-align: middle;
     border: 1px solid #000;
}
th {
    background: rgba(0,0,0,.05);
    font-weight: 700;
  
</style>
@endsection

@section('js')
<script type="text/javascript">
    function confirm_delete()
    {
        if(!confirm("Bạn chắc chắn muốn xóa giao dịch này"))
          event.preventDefault();            
    }

var type = '';
$("select[name='type']").change(function(){
  type = $("select[name='type']").val();
  if(type == 1){
    jQuery('.order-month').hide();
    jQuery('.order-day').show();
  }else {
    jQuery('.order-day').hide();
    jQuery('.order-month').show();
  }
})
var start_month = $("input[name='start_month']").val();

var ts = start_month+"-01";
$("input[name='start_month']").change(function(){
  start_month =$("input[name='start_month']").val();
  ts = start_month+"-01";
  console.log(ts);
})

var start_date = $("input[name='start_date']").val();
$("input[name='start_date']").change(function(){
  start_date =$("input[name='start_date']").val();
})

var end_date =$("input[name='end_date']").val();
$("input[name='end_date']").change(function(){
  end_date =$("input[name='end_date']").val();
})

var end_month = $("input[name='end_month']").val();
var te = end_month+"-01";
$("input[name='end_month']").change(function(){
  end_month =$("input[name='end_month']").val();
  te = end_month+"-01";
  console.log(te);
})    

$("#search").click(function(e){
     
    if(type == ''){
        e.preventDefault();
        jQuery('p').remove();
        jQuery('.alert-danger').show();
        jQuery('.alert-danger').append('<p>Chọn loại lọc (theo ngày/theo tháng)</p>');
    }
    if(type == 1){
        e.preventDefault();
          $.ajax({
            header: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            url : `/transactions/show/per-day`,
            datatType : 'json',
            type: 'GET',
            data:{
                type : type,
                start_date : start_date,
                end_date : end_date,
            },
            success: function(data) {
                if(data.errors) {
                  $("#show-table").find("div").remove();
                    jQuery('p').remove();
                    jQuery.each(data.errors, function(key, value){
                        jQuery('.alert-danger').show();
                        jQuery('.alert-danger').append('<p>'+value+'</p>');
                    });
                } else {
                    jQuery('.alert-danger').hide();
                    $("#show-table").find("div").remove();
                    var html ='';
                    html += `<div class="form-group"><ul class="list-group">`;
                    jQuery.each(data, function(key, value){
                        html += `<li class="list-group-item">`+key;
                        if(value.length != 0) {
                            jQuery.each(value, function(k, v){
                                html += `<ul class="list-group"><li class="list-group-item">Giao dịch từ `+v['FROM']+` đến `+v['TO']+` với số tiền là `+v['MONEY']+`</li></ul>`;
                            });
                        }
                        html += `</li>`;
                    });
                    html += `</ul></div>`;
                    $("#show-table").append(html);                 
                }
            },
          })
    }
    if(type == 2){
        e.preventDefault();
          $.ajax({
            header: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            url : `/transactions/show/per-month`,
            datatType : 'json',
            type: 'GET',
            data:{
                type : type,
                start_month : start_month,
                end_month : end_month,
                te: te,
                ts: ts,
            },
                success: function(data){
                if(data.errors) {
                  $("#show-table").find("div").remove();
                    jQuery('p').remove();
                    jQuery.each(data.errors, function(key, value){
                        jQuery('.alert-danger').show();
                        jQuery('.alert-danger').append('<p>'+value+'</p>');
                    });
                } else {
                    jQuery('.alert-danger').hide();
                    $("#show-table").find("div").remove();
                    var html ='';
                    html += `<div class="form-group"><ul class="list-group">`;
                    jQuery.each(data, function(key, value){
                        html += `<li class="list-group-item">Tháng `+key;
                        if(value.length != 0) {
                            jQuery.each(value, function(k, v){
                                html += `<ul class="list-group"><li class="list-group-item">Giao dịch từ `+v['FROM']+` đến `+v['TO']+` với số tiền là `+v['MONEY']+` vào ngày `+v['DAY']+`</li></ul>`;
                            });
                        }
                        html += `</li>`;
                    });
                    html += `</ul></div>`;
                    $("#show-table").append(html);                 
                }
            }
          })
    }    
});
</script>
@endsection