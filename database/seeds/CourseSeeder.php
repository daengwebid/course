<?php

use Illuminate\Database\Seeder;
use App\Instructor;
use App\Course;
use App\Student;
use App\Payment;
use App\Payment_detail;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $instructor = Instructor::create([
            'name' => 'Anugrah sandi',
            'gender' => 'L'
        ]);

        $course = Course::create([
            'user_id' => 1,
            'instructor_id' => $instructor->id,
            'name' => 'Belajar Laravel',
            'description' => 'Belajar laravel level beginner',
            'price' => 150000
        ]);

        $student = Student::create([
            'email' => 'coba@gmail.com',
            'password' => bcrypt('secret'),
            'gender' => 'L',
            'active' => true
        ]);

        $payment = Payment::create([
            'code' => str_random(10) . '-',
            'student_id' => $student->id,
            'amount' => $course->price,
            'date' => \Carbon\Carbon::now()->format('Y-m-d'),
            'status' => false
        ]);

        $payment_detail = Payment_detail::create([
            'payment_id' => $payment->id,
            'course_id' => $course->id
        ]);

    }
}
