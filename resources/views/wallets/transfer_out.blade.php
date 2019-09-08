@extends('_layout.layout')
@section('title')
Giao dịch chuyển tiền bên ngoài
@endsection
@section('content')
    <div class="conten-wrapper">
        <section class="content container-fluid">
            <div class="container">
                <h2>Giao dịch chuyển tiền ngoài tài khoản</h2>
                <form class="form-horizontal" method="POST" action="{{ route('wallets.post_transfer') }}" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                    <div class="form-group">
                        <p style="text-align: center;"><span class="error">* required field</span></p>
                    </div>
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="type" value="1">
                    <input type="hidden" name="trans" value="2">
                    <div class="form-group{{ $errors->has('from_wallet') ? ' has-error' : '' }}" id="from_trans">
                        <label for="from_wallet" class="col-md-4 control-label">Ví chuyển tiền<span class="error">*</span></label>

                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="from_wallet" id="from_wallet" required>
                                <option selected value="">Chọn ví chuyển đi</option>
                                @foreach($wallets as $wallet)
                                    <option value="{{ $wallet->id }}" @if ($wallet->id == old('from_wallet'))
                                        selected 
                                    @endif>{{ $wallet->name.'-'.$wallet->ssid }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('from_wallet'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('from_wallet') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                       
                    <div class="form-group{{ $errors->has('ssid') ? ' has-error' : '' }}" id="to_trans">
                        <label for="ssid" class="col-md-4 control-label">SSID Ví nhận tiền<span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="ssid" type="text" min = "0" step="10000" class="form-control" name="ssid" value="{{ old('ssid') }}" required autofocus>

                            @if ($errors->has('ssid'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ssid') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('money_from') ? ' has-error' : '' }}" id="so_du">
                        <label for="money_from" class="col-md-4 control-label">Số dư tài khoản <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input type="number" class="form-control" name="money_from" id="money_from" value="{{ old('money_from') }}" readonly>

                            @if ($errors->has('money_from'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('money_from') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('money') ? ' has-error' : '' }}">
                        <label for="money" class="col-md-4 control-label">Số tiền chuyển <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="money" type="number" min = "0" step="10000" class="form-control" name="money" value="{{ old('money') }}" required autofocus>

                            @if ($errors->has('money'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('money') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        <label for="code" class="col-md-4 control-label">Mã bí mật (Nhập để thực hiện giao dịch) <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="code" type="password" class="form-control" name="code" required autofocus>

                            @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                                                          
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Chuyển tiền
                            </button>
                            <a href="{{ route("wallets.index") }}" type="button" class="btn btn-info">Quay lại</a>
                        </div>

                    </div>
                 </form>
            </div>
        </section>  
    </div>
@endsection
@section('css')
<style type="text/css">
    h2 {
        text-align: center;
    }
    .error {
        color: red;
    }
</style>
@endsection
@section('js')
<script type="text/javascript">
   
    $(document).ready(function () {
        $("select[name='from_wallet']").on('change',function() {
            var from_wallet = $(this).val();  
            if(from_wallet != 0){
                $.ajax({
                    type:'POST',
                    headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    dataType   :'JSON',
                    url:'/transfer/change/user',
                    data:{id: {{ Auth::id() }} ,from_wallet: from_wallet, type : 2},
                    success:function(result){
                        console.log(result);
                        $('#money_from').val(result[1]);
                    }
                }); 
            }else{
                $("#so_du").hide();
            }
        });

});
</script>
@endsection
