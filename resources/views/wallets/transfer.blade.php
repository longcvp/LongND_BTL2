@extends('_layout.layout')
@section('title')
Giao dịch chuyển tiền
@endsection
@section('content')
	<div class="conten-wrapper">
		<section class="content container-fluid">
			<div class="container">
				<h2>Giao dịch chuyển tiền</h2>
				<form class="form-horizontal" method="POST" action="{{ route('wallets.post_transfer') }}" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                    <div class="form-group">
                        <p style="text-align: center;"><span class="error">* required field</span></p>
                    </div>
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                    <div class="form-group{{ $errors->has('from_wallet') ? ' has-error' : '' }}">
                        <label for="from_wallet" class="col-md-4 control-label">Ví chuyển tiền<span class="error">*</span></label>

                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="from_wallet" id="from_wallet" required>
                                <option selected value="">Chọn</option>
                                @foreach($wallets as $wallet)
                                    <option value="{{ $wallet->id }}" >{{ $wallet->name.'-'.$wallet->ssid }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('from_wallet'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('from_wallet') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}" id="to_me">
                        <label for="type" class="col-md-4 control-label">Thể loại chuyển tiền<span class="error">*</span></label>

                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="type" id="type" required>
                                <option selected value="">Chọn ví chuyển tiền trước </option>
                                <option selected value="">Chọn ví chuyển tiền trước </option>
                                <option selected value="">Chọn ví chuyển tiền trước </option>
                                
                            </select>
                            @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>    
                    <div class="form-group{{ $errors->has('to_wallet') ? ' has-error' : '' }}" id="to_me">
                        <label for="to_wallet" class="col-md-4 control-label">Ví nhận tiền<span class="error">*</span></label>

                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="to_wallet" id="to_wallet" required>
                                <option selected value="">Chọn ví chuyển tiền trước </option>
                            </select>
                            @if ($errors->has('to_wallet'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('to_wallet') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('money') ? ' has-error' : '' }}">
                        <label for="money" class="col-md-4 control-label">Số tiền chuyển <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="money" type="number" mim = "0" step="10000" class="form-control" name="money" value="{{ old('money') }}" required autofocus>

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
                            <input id="code" type="password" class="form-control" name="code" value="{{ old('code') }}" required autofocus>

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
    $("select[name='from_wallet']").on('change',function(){
        var from_wallet = $(this).val();
        if(from_wallet != 0){
            $.ajax({
                type:'POST',
                headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                url:'/trasfer/change',
                data:'from_wallet='+from_wallet,
                success:function(html){
                    $('#to_wallet').html(html); 
                }
            }); 
        }else{
            $('#to_wallet').html('<option value="">Chọn danh tài khoản chuyển đến trước</option>');
        }
    });

});
</script>
@endsection
