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

    public function edit()
    {
        $id = Request::instance()->param('id/d');

        //获取所有的教师信息
        $teachers = TeacherModel::all();
        $this->assign('teachers', $teachers);

        //获取用户操作的班级信息
        if (false === $KlassModel = KlassModel::get($id)) {
            return $this->error('系统未找到id为' .$id. '的记录');
        }
        $this->assign('KlassModel', $KlassModel);
        return $this->fetch();
    }

    public function update()
    {
        $id = Request::instance()->post('id/d');
        //获取输入的班级信息
        $KlassModel = KlassModel::get($id);
        if (is_null($KlassModel)) {
            return $this->error('系统未找到ID为' .$id. '的记录');
        }

        //数据更新
        $KlassModel->name = Request::instance()->post('name');
        $KlassModel->teacher_id = Request::instance()->post('teacher_id/d');
        if (!$KlassModel->validate()->save($KlassModel->getData())) {
            return $this->error('更新错误: ' .$KlassModel->getError());
        } else {
            return $this->success('操作成功', url('index'));
        }
    }

    public function delete()
    {
        $id = Request::instance()->param('id/d');
        //判断是否接收成功
        if (is_null($id) || 0 === $id) {
            throw new \Exception('未获取到ID信息', 1);
        }
        //获取要删除的对象
        $KlassModel = KlassModel::get($id);
        //判断要删除对象是否存在
        if (is_null($KlassModel)) {
            throw new \Exception("不存在ID为" .$id. '的班级，删除失败', 1);
        }
        //删除对象
        if (!$KlassModel->delete()) {
            return $this->error('删除失败：' .$Teacher->getError());
        }
        //进行跳转
        return $this->success('删除成功', url('index'));
    }
}
