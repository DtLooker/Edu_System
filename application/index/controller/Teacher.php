<?php
namespace app\index\controller;

use app\common\model\Teacher as TeacherModel;
use think\Controller;
use think\Request;

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

    public function insert()
    {

        //Request::instance()返回一个对象，调用这个对象的post方法，得到post数据
        $postData = Request::instance()->post();

        //实例化Teacher空对象
        $Teacher = new TeacherModel();

        //为对象的属性赋值
        $Teacher->name = $postData['name'];
        $Teacher->username =  $postData['username'];
        $Teacher->sex = $postData['sex'];
        $Teacher->email = $postData['email'];

        //新增对象至数据表
        $result = $Teacher->validate(true)->save($Teacher->getData());

        //反馈结果
        if (false === $result) {
            return '新增失败：' . $Teacher->getError();
        } else {
            return '新增成功。新增ID为：' .$Teacher->id;
        }
    }

    public function add()
    {
        $html = $this->fetch();
        return $html;
    }

    public function delete()
    {
        /**
         * 1. delete删除对象时候，删除对象不存在，则会报错。删除特定错误
         * 2. destory删除对象时候，即使删除对象不存在，也不会抛出异常。只会告诉你删除的记录条
         *    数为0， 需要批量删除数据时候用此方法。
         */

        //获取pathinfo传入的ID值
        $id = Request::instance()->param('id/d'); //“/d”表示将数值转换成“整形"

        if (is_null($id) || 0 ===$id) {
            return $this->error('未获取到ID信息');
        }

        //获取到要删除的对象
        $Teacher = TeacherModel::get($id);
        //要删除的对象不存在
        if (is_null($Teacher)) {
            return $this->error('不存在id为' . $id . '的教师，删除失败');
        }
        //删除对象
        if (!$Teacher->delete()) {
            return $this->error('删除失败: ' . $Teacher->getError());
        }
        //进行跳转
        return $this->success('删除成功', url('index'));
    }
}
