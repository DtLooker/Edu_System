<?php
namespace app\index\controller;

use app\common\model\Student as StudentModel;

class Student extends Index
{
    public function index()
    {
        $students = StudentModel::paginate();
        $this->assign('students', $students);
        return $this->fetch();
    }
}
