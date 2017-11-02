<?php
namespace app\index\controller;

use app\common\model\Teacher as TeacherModel;
use think\Controller;

/**
 * 教师管理
 */
class Teacher extends Controller
{
    public function index()
    {
        $TeacherModel = new TeacherModel();
        $teachers = $TeacherModel->select();

        //向V层传递数据
        $this->assign('teachers', $teachers);
        //取回打包好的数据
        $htmls = $this->fetch();
        //将数据返回给用户
        return $htmls;
    }
}
