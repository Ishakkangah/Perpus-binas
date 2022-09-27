@extends('account.index')

@section('content')

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="module module-login span8 offset2">
				<form class="form-vertical" action="{{ URL::route('student-registration-post') }}" method="POST">
					<div class="module-head">
						<h3>FORM PENDAPTARAN SISWA</h3>
					</div>
					<div class="module-body">
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span6" type="text" placeholder="Nama awal" name="first" value="{{ Request::old('first') }}" /> 
								<input class="span6" type="text" placeholder="Nama akhir" name="last" value="{{ Request::old('last') }}" /> 
								
								@error('first')
									<div style="color:crimson">{{ $message }}</div>	
								@enderror
								
								@error('last')
									<div style="color:crimson">{{ $message }}</div>	
								@enderror
							</div>
						</div>
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span4" type="number" placeholder="Nomor gulungan" name="rollnumber" value="{{ Request::old('rollnumber') }}" /> 								
								<select class="span4" style="margin-bottom: 0;" name="branch">
									<option value="0">Pilih cabang</option>
									@foreach($branch_list as $branch)
				                        <option value="{{ $branch->id }}">{{ $branch->branch }}</option>
				                    @endforeach
								</select>
								<input class="span4" type="number" placeholder="Tahun" name="year" value="{{ Request::old('year') }}" /> 

								@error('rollnumber')
									<div style="color:crimson">{{ $message }}</div>
								@enderror
								
								@error('branch')
									<div style="color:crimson">{{ $message }}</div>
								@enderror
								
								@error('year')
									<div style="color:crimson">{{ $message }}</div>
								@enderror
								
							</div>
						</div>
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span8" type="email" placeholder="E-mail" name="email" autocomplete="false" value="{{ Request::old('email') }}" /> 
								<select class="span4" style="margin-bottom: 0;" name="category">
									<option value="0">Pilih kategori</option>
									@foreach($student_categories_list as $student_category)
				                        <option value="{{ $student_category->cat_id }}">{{ $student_category->category }}</option>
				                    @endforeach
								</select>

								@error('email')
									<div style="color: crimson">{{ $message }}</div>
								@enderror

								@error('category')
									<div style="color: crimson">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="module-foot">
						<div class="control-group">
							<div class="controls clearfix">
								<button type="submit" class="btn btn-primary pull-right">Daptar ke perpustakaan</button>
								@csrf
							</div>
						</div>
						<a href="{{ URL::route('account-sign-in') }}">Kembali!</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@include('account.style')

@stop
