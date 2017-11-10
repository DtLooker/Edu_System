<?php
namespace app\index\controller;

use app\common\model\Teacher as TeacherModel;
use think\Controller;
use think\Request;

/**
 * 教师管理
 */
class Teacher extends Index
{
    public function index()
    {

        //获取查询信息
        //$name = Request::instance()->get('name');
        $name = input('get.name');

        $pageSize = 5;//每页显示5条数据

        $TeacherModel = new TeacherModel();

        //定查询信息
        $teachers = $TeacherModel->where('name', 'like', '%' .$name. '%')
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
        $this->assign('teachers', $teachers);
        //取回打包好的数据
        $htmls = $this->fetch();
        //将数据返回给用户
        return $htmls;
    }

    public function save()
    {
        //实例化
        $TeacherModel = new TeacherModel();
        //新增数据
        if (!$this->saveTeacher($TeacherModel)) {
            return $this->erro('操作失败' . $Teacher->getError());
        }
        //新增成功，跳转至index触发器
        return $this->success('操作成功', url('index'));
    }

    public function add()
    {
        //实例化
        $TeacherModel = new TeacherModel();
        //设置默认值
        $TeacherModel->id = 0;
        $TeacherModel->name = '';
        $TeacherModel->username = '';
        $TeacherModel->sex = 0;
        $TeacherModel->email = '';
        $this->assign('Teacher', $TeacherModel);
        //调用edit模板
        return $this->fetch('edit');
    }

    public function delete()
    {
        /**
         * 1. delete删除对象时候，删除对象不存在，则会报错。删除特定错误
         * 2. destory删除对象时候，即使删除对象不存在，也不会抛出异常。只会告诉你删除的记录条
         *    数为0， 需要批量删除数据时候用此方法。
         */

        //“/d”表示将数值转换成“整形"

        //获取get数据
        $id = Request::instance()->param('id/d');
        //判断是否接收成功
        if (is_null($id) || 0 === $id) {
            throw new \Exception('未获取到ID信息', 1);
        }
        //获取要删除的对象
        $Teacher = TeacherModel::get($id);
        //要删除的对象存在
        if (is_null($Teacher)) {
            throw new \Exception("不存在ID为" .$id. '的教师，删除失败', 1);
        }
        //删除对象
        if (!$Teacher->delete()) {
            return $this-> error('删除失败：' . $Teacher->getError());
        }
        //进行跳转
        return $this->success('删除成功', url('index'));
    }

    public function edit()
    {
        //获取传入ID
        $id = Request::instance()->param('id/d');
        //判断是否成功接收
        if (is_null($id) || 0 === $id) {
            throw new \Exception('未获取到ID信息', 1);
        }
        //在Teacher表模型中国获取当前记录
        if (is_null($Teacher = TeacherModel::get($id))) {
            $this->error('系统未找到ID为' .$id. '的记录');
        }
        //将数据传递给V层
        $this->assign('Teacher', $Teacher);
        //获取封装好的V层内容
        $htmls = $this->fetch();
        //将封装好的V层内容返回给用户
        return $htmls;
    }

    public function update()
    {
        //接收数据，获取要更新的关键字
        $id = Request::instance()->post('id/d');
        //获取当前对象
        $TeacherModel = TeacherModel::get($id);

        if (!is_null($TeacherModel)) {
            if (!$this->saveTeacher($TeacherModel, true)) {
                return $this->error('操作失败' . $Teacher->getError());
            }
        } else {
            return $this->error('当前操作的记录不存在');
        }
        return $this->success('操作成功', url('index'));
    }

    /**
     * 对数据进行保存或者更新
     * @param  TeacherModel $TeacherModel [教师]
     * @return [bool]                     [description]
     */
    private function saveTeacher(TeacherModel &$TeacherModel, $isUpdate = false)
    {
        //写入要更新的数据
        $TeacherModel->name = input('post.name');
        if (!$isUpdate) {
            $TeacherModel->username = Request::instance()->post('username');
        }
        $TeacherModel->sex = input('post.sex/d');
        $TeacherModel->email = input('post.email');

        //更新或保存
        return $TeacherModel->validate(true)->save($TeacherModel->getData());
    }
}
