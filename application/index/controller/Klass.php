<?php

namespace app\index\controller;

use app\common\model\Klass as KlassModel;
use app\common\model\Teacher as TeacherModel;
use think\Request;

class Klass extends Index
{
    public function index()
    {
        //获取查询信息
        $name = input('get.name');
        //每页显示2条数据
        $pageSize = 2;

        $KlassModel = new KlassModel();
        //定制查询信息
        $klasses = $KlassModel->where('name', 'like', '%'.$name.'%')
                                ->paginate(
                                    $pageSize,
                                    false,
                                [
                                    'query'=>[
                                        'name' => $name,
                                    ],
                                ]
                                );
        //向V层传递数据
        $this->assign('klasses', $klasses);
        //取回打包好的数据，将数据返回给用户
        return $this->fetch();
    }

    public function add()
    {
        //获取所有教师信息
        $teachers = TeacherModel::all();
        $this->assign('teachers', $teachers);
        return $this->fetch();
    }

    public function save()
    {
        //实例化请求信息
        $Request = Request::instance();
        //实例化班级并赋值
        $KlassModel = new KlassModel();
        $KlassModel->name = $Request->post('name');
        $KlassModel->teacher_id = $Request->post('teacher_id/d');
        //添加数据
        if (!$KlassModel->validate(true)->save($KlassModel->getData())) {
            return $this->error('数据添加错误:'.$KlassModel->getError());
        }
        return $this->success('操作成功', url('index'));
    }
}
