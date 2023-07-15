<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudent;
use App\Http\Requests\UpdateStudent;
use App\Mail\StudentCreation;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('user')->get();
        
        return view('admin.student.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudent $request)
    {
        $validatedData = $request->validated();

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);

        $user->save();

        $student = new Student();
        $student->user_id = $user->id;
        $student->course = $validatedData['course'];
        $student->student_number = $validatedData['student_number'];
        $student->year = $validatedData['year'];
        $student->address = $validatedData['address'];
        
        Mail::to($user)->send(
            new StudentCreation($user,$validatedData['password'])
        );

        $student->save();

        return redirect()->route('admin.student.index')->with('success', 'New student created');

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
        $student = Student::with('user')->findOrFail($id);
        return view('admin.student.edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudent $request, $id)
    {
        $validatedData = $request->validated();
        $student = Student::with('user')->findOrFail($id);

        $email = $request->validate([
            'email' => "bail|required|min:3|email|unique:users,email," . $student->user->id,
        ]);

        if (!empty($validatedData['password'])) {

            $password = $request->validate([
                'password' => "min:6",
            ]);
            $password = Hash::make($password['password']);
            $student->user->password = $password;
        }
        
        // STUDENT USER INFO SAVE
        $student->user->name = $validatedData['name'];
        $student->user->email = $email['email'];
        $student->user->save();


        $student_number = $request->validate([
            'student_number' => "bail|required|min:3|integer|unique:students,student_number," . $student->id,
        ]);

        $student->student_number = $student_number['student_number'];
        $student->course = $validatedData['course'];
        $student->year = $validatedData['year'];
        $student->address = $validatedData['address'];
        $student->save();
        

        return redirect()->route('admin.student.index')->with('success', 'Student updated successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
