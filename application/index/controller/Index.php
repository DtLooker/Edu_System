<?php
namespace app\index\controller;

use think\Controller;
use app\common\model\Teacher as TeacherModel; //教师模型

class Index extends Controller
{
    public function __construct()
    {
        //调用父类构造函数（必须）
        parent::__construct();
        //验证用户是否登录
        if (!TeacherModel::isLogin()) {
            return $this->error('pls login first', url('Login/index'));
        }
    }

    public function index()
    {
    }
}
