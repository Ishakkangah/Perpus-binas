<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Logs;
use App\Models\Books;
use App\Models\Issue;
use App\Models\Branch;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentCategories;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    public function __construct(){

		$this->filter_params = array('branch','year','category');

	}

	public function index()
	{
		$conditions = array(
			'approved'	=> 0,
			'rejected'	=> 0
		);

		$students = Student::join('branches', 'branches.id', '=', 'students.branch')
		->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
		->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year')
			->where($conditions)
			->orderBy('student_id');

		// $this->filterQuery($students);
		$students = $students->get();
		// dd($students);
        return $students;
	}

	public function StudentByAttribute(Request $request)
	{
		// dd($request->branch );
		$conditions = array(
			'approved'	=> 0,
			'rejected'	=> 0
		);
		if ($request->branch != 0) {
			
			$students = Student::join('branches', 'branches.id', '=', 'students.branch')
			->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
			->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year')
				->where($conditions)
				->where('students.branch', $request->branch)
				->orderBy('student_id');
			$students = $students->get();
			return $students;
		
		}

		elseif ($request->category != 0) {
			
			$students = Student::join('branches', 'branches.id', '=', 'students.branch')
			->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
			->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year')
				->where($conditions)
				->where('students.category', $request->category)
				->orderBy('student_id');
			$students = $students->get();
			return $students;
		
		}

		elseif ($request->year != 0) {
			// dd($request->year );
			$students = Student::join('branches', 'branches.id', '=', 'students.branch')
			->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
			->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year')
				->where($conditions)
				->where('students.year', $request->year)
				->orderBy('student_id');
			$students = $students->get();

			return $students;
		
		}
		return "Hasil tidak ditemukan";

		
	}


	public function create()
	{
		$conditions = array(
			'approved'	=> 1,
			'rejected'	=> 0
		);

		$students = Student::join('branches', 'branches.id', '=', 'students.branch')
		->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
		->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year', 'email_id', 'books_issued')
			->where($conditions)
			->orderBy('student_id');

		// $this->filterQuery($students);
		$students = $students->get();

        return $students;
	}


	public function store()
	{
		//
	}


	public function show($id)
	{
		$student = Student::find($id);
		if($student == NULL){
			throw new Exception('ID Siswa salah!');
		}

		$student->year = (int)substr($student->year, 2, 4);

		$student_category = StudentCategories::find($student->category);
		$student->category = $student_category->category;

		$student_branch = Branch::find($student->branch);
		$student->branch = $student_branch->branch;


		if($student->rejected == 1){
			unset($student->approved);
			unset($student->books_issued);
			$student->rejected = (bool)$student->rejected;

			return $student;
		}

		if($student->approved == 0){
			unset($student->rejected);
			unset($student->books_issued);
			$student->approved = (bool)$student->approved;

			return $student;
		}

		unset($student->rejected);
		unset($student->approved);

		$student_issued_books = Logs::select('book_issue_id', 'issued_at')
			->where('student_id', '=', $id)
			->orderBy('created_at', 'desc')
			->take($student->books_issued)
			->get();

		foreach($student_issued_books as $issued_book){
			$issue = Issue::find($issued_book->book_issue_id);
			$book = Books::find($issue->book_id);
			$issued_book->name = $book->title;

			$issued_book->issued_at = date('d-M', strtotime( $issued_book->issued_at));
		}

		$student->issued_books = $student_issued_books;

		return $student;
	}


	public function edit($id)
	{
		//
	}

	public function update(Request $request, $id){
        $flag = (bool)$request->get('flag');

        $student = Student::findOrFail($id);

		if($flag){
			// if student is approved
	        $student->approved = 1;
		} else {
			// if student is rejected for some reason
			$student->rejected = 1;
		}

        $student->save();

        return "Status persetujuan/penolakan siswa berhasil diubah.";
	}


	public function destroy(Request $request, $id)
	{
		// dd($request->all());
		if ($request->category) {
			
			$student = StudentCategories::find($id);
			$student->delete();
			if (!$student) {
				return "Kategori siswa gagal di hapus!.";
			}else {
				return redirect(route('settings'));
			}
		}elseif ($request->branch) {
			
			$branch = Branch::find($id);
			$branch->delete();
			if (!$branch) {
				return "Jurusan gagal di hapus!.";
			}else {
				return redirect(route('settings'));
			}
		}
	}


	public function renderStudents(){
		$db_control = new HomeController;
		return view('panel.students')
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}

	public function renderApprovalStudents(){
		$db_control = new HomeController;
		return view('panel.approval')
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}

	public function getRegistration(){
		$db_control = new HomeController;
		return view('public.registration')
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}

	public function postRegistration(Request $request){

		$validator = $request->validate([

				'first'			=> 'required|alpha',
				'last'			=> 'required|alpha',
				'rollnumber'	=> 'required|integer',
				'branch'		=> 'required|between:0,10',
				'year'			=> 'required|integer',
				'email'			=> 'required|email',
				'category'		=> 'required|between:0,5'

		]);

		if(!$validator) {
			return Redirect::route('student-registration')
				->withErrors($validator)
				->withInput();   // fills the field with the old inputs what were correct

		} else {
			$student = Student::create(array(
				'first_name'	=> $request->get('first'),
				'last_name'		=> $request->get('last'),
				'category'		=> $request->get('category'),
				'roll_num'		=> $request->get('rollnumber'),
				'branch'		=> $request->get('branch'),
				'year'			=> $request->get('year'),
				'email_id'		=> $request->get('email'),
			));

			if($student){
				return Redirect::route('student-registration')
					->with('global', 'Permintaan Anda telah diajukan, Anda akan segera disetujui!');
			}
		}
	}

	public function Setting()
	{
		$branches = Branch::all();
		$student_category = StudentCategories::all();

		return view('panel.addsettings')
		->with('branches', $branches)
		->with('student_category', $student_category);
	}

	public function StoreSetting(Request $request)
	{
		// dd($request->all());
		if ($request->category) {
			
			$student = StudentCategories::create($request->all());

			if (!$student) {
				return "Kategori Siswa Gagal Disimpan.";
			}else {
				return "Kategori Siswa Berhasil Disimpan!.";
				// return back();
			}
		}elseif ($request->branch) {
			
			$branch = Branch::create($request->all());

			if (!$branch) {
				return "Cabang sekolah gagal disimpan.";
			}else {
				return "Cabang sekolah berhasil disimpan!.";
				// return back();
			}
		}

		
	}
}
