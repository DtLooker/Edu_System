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
        try {
            $name = Request::instance()->get('name');

            $pageSize = 5;//每页显示5条数据

            $TeacherModel = new TeacherModel();

            //定制查询信息
            if (!empty($name)) {
                $TeacherModel->where('name', 'like', '%' . $name . '%');
            }

            $teachers = $TeacherModel->paginate($pageSize, false, [
                'query'=>[
                    'name' => $name,
                ],
            ]);

            //向V层传递数据
            $this->assign('teachers', $teachers);
            //取回打包好的数据
            $htmls = $this->fetch();
            //将数据返回给用户
            return $htmls;
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            //throw $e;
            return $e->getMessage();
        }
    }

    public function insert()
    {
        try {
            $message = '';
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
                $message = '新增失败：' . $Teacher->getError();
            } else {
                //新增成功，跳转至教师管理列表
                return $this->success('用户' .$Teacher->name . '新增成功。', url('index'));
            }
            //ThinkPHP内置异常，向上抛出，给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;
            //获取到正常异常时，输出异常
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $this->error($message);
    }

    public function add()
    {
        try {
            $htmls = $this->fetch();
            return $htmls;
        } catch (\Exception $e) {
            return '系统错误'. $e->getMessage();
        }
    }

    public function delete()
    {
        /**
         * 1. delete删除对象时候，删除对象不存在，则会报错。删除特定错误
         * 2. destory删除对象时候，即使删除对象不存在，也不会抛出异常。只会告诉你删除的记录条
         *    数为0， 需要批量删除数据时候用此方法。
         */

        //“/d”表示将数值转换成“整形"
        try {
            //获取get数据
            $id = Request::instance()->param('id/d');
            //判断是否接收成功
            if (0 === $id) {
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
            //获取到正常的异常时候，直接向上抛出，交给ThinkPhp处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        //进行跳转
        return $this->success('删除成功', $Request->header('referer'));
    }

    public function edit()
    {
        try {
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
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update()
    {
        try {
            //接收数据，获取要更新的关键字
            $id = Request::instance()->post('id/d');
            $message = '更新成功';

            //获取当前对象
            $Teacher = Teacher::get($id);

            if (!is_null($Teacher)) {
                //写入要更新的数据
                $Teacher->name = Request::instance()->post('name');
                $Teacher->username = Request::instance()->post('username');
                $Teacher->sex = Request::instance()->post('sex/d');
                $Teacher->email = Request::instance()->post('email');

                //更新
                if (false === $Teacher->validate(true)->save()) {
                    return $this->error('更新失败' .$Teacher->getError());
                }
            } else {
                //调用PHP内置类时，需要在前面加上\
                throw new \Exception('所更新的记录不存在', 1);
            }
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;
        } catch (\Exception $e) {
            return  $e->getMessage();
        }
        return $this->success('操作成功', url('index'));
    }
}
