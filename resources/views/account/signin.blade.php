@extends('account.index')

@section('content')

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="module module-login span4 offset2">
				<form class="form-vertical" action="{{ URL::route('account-sign-in-post') }}" method="POST">
					@csrf
					<div class="module-head">
						<h3>MASUK ADMIN</h3>
					</div>
					<div class="module-body">
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span12" type="text" name="username" placeholder="Nama pengguna" value="{{ Request::old('login') }}" autofocus>
								@error('username')
									<div style="color:crimson">{{ $message }}</div>
								@enderror			
							</div>
						</div>
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span12" type="password" name="password" placeholder="Kata sandi">
								@error('password')
									<div style="color:crimson">{{ $message }}</div>
								@enderror											
							</div>
						</div>
					</div>
					<div class="module-foot">
						<div class="control-group">
							<div class="controls clearfix">
								<button type="submit" class="btn btn-primary pull-right">Gabung</button>
								<label class="checkbox">
									<input type="checkbox" name="remember" id="remember"> Ingat saya
								</label>
							</div>
						</div>
						<a href="{{ URL::route('account-create') }}">Admin baru? Daptar</a>
					</div>
				</form>
			</div>
			<div class="module module-login span4 offset1">
				<div class="module-head">
					<h3>BAGIAN SISWA</h3>
				</div>
				<div class="module-body">
                    <p><a href="{{ URL::route('student-registration') }}"><strong>Form pendaptaran siswa</strong></a></p>
                    <p><a href="{{ URL::route('search-book') }}"><strong>Cari buku</strong></a></p>
				</div>
			</div>
        </div>
	</div>
</div>
@include('account.style')
@stop