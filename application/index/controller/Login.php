<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\common\model\Teacher as TeacherModel;

class Login extends Controller
{
    //用户登录表单
    public function index()
    {
        //显示登陆表单
        return $this->fetch();
    }

    //处理用户提交的登录数据
    public function login()
    {
        //接收post信息
        $postData = Request::instance()->post();

        //直接调用M层方法，进行登陆
        if (TeacherModel::login($postData['username'], $postData['password'])) {
            return $this->success('login success', url('Teacher/index'));
        } else {
            //用户名不存在，跳转到登录界面
            return $this->error('username not exist', url('index'));
        }
    }
}
