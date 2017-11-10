<?php
namespace app\index\controller;

use app\common\model\Course as CourseModel;
use app\common\model\Klass as KlassModel;
use app\common\model\KlassCourse;
use think\Request;

/**
 * 课程管理
 */
class Course extends Index
{
    public function index()
    {
        $courses = CourseModel::paginate();
        $this->assign('courses', $courses);
        return $this->fetch();
    }

    public function add()
    {
        //$klasses = KlassModel::all();
        $this->assign('Course', new CourseModel());

        return $this->fetch();
    }

    public function save()
    {
        //存课程信息
        $CourseModel = new CourseModel();
        $CourseModel->name = Request::instance()->post('name');

        //新增数据并验证。验证类
        if (!$CourseModel->validate(true)->save($CourseModel->getData())) {
            return $this->error('保存错误: '. $CourseModel->getError());
        }

        // -------------------------- 新增班级课程信息 --------------------------
        //接收klass_id这个数组
        $klassIds = Request::instance()->post('klass_id/a'); // /a表示获取的类型为数组
        //利用klass_id这个数组，拼接为包括klass_id和course_id的二维数组
        if (!is_null($klassIds)) {
            if (!$CourseModel->Klasses()->saveAll($klassIds)) {
                return $this->error('课程-班级信息保存错误: ' .$CourseModel->Klasses()->getError());
            }
        }
        // -------------------------- 新增班级课程信息(end) --------------------------
        unset($CourseModel);
        return $this->success('操作成功', url('index'));
    }

    public function edit()
    {
        $id = Request::instance()->param('id/d');
        $CourseModel = CourseModel::get($id);

        if (is_null($CourseModel)) {
            return $this->error('不存在ID为' . $id . '的记录');
        }
        $this->assign('Course', $CourseModel);
        return $this->fetch();
    }

    public function update()
    {

        //获取当前课程
        $id = Request::instance()->post('id/d');
        if (is_null($CourseModel = CourseModel::get($id))) {
            return $this->error('不存在ID为' .$id. '的记录');
        }

        //更新课程名
        $CourseModel->name = Request::instance()->post('name');
        if (is_null($CourseModel->validate(true)->save($CourseModel->getData()))) {
            return $this->error('课程信息更新发生错误: ' .$CourseModel->getError());
        }

        //删除原有信息
        $map = ['course_id' => $id];

        //执行删除操作，由于存在成功删除0条记录，故使用false进行判断，
        //而不能使用if(!KlassCourse::where($map)->delete())
        //删除0条记录也算成功
        if (false === $CourseModel->KlassCourse()->where($map)->delete()) {
            return $this->error('删除班级课程关联信息发生错误' .$CourseModel->$KlassCourse()->getError());
        }

        //增加新增数据，执行添加操作
        $klassIds = Request::instance()->post('klass_id/a');
        if (!is_null($klassIds)) {
            if (!$CourseModel->Klasses()->saveAll($klassIds)) {
                return $this->error('课程-班级信息保存错误: '.$CourseModel->Klasses()->getError());
            }
        }
        return $this->success('更新成功', url('index'));
    }
}
