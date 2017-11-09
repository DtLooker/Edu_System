<?php
namespace app\index\controller;

use app\common\model\Course as CourseModel;
use app\common\model\Klass as KlassModel;
use app\common\model\KlassCourse;
use think\Request;

/**
 * 课程表
 */
class Course extends Index
{
    public function index()
    {
    }

    public function add()
    {
        $klasses = KlassModel::all();
        $this->assign('klasses', $klasses);
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
                return $this->error('课程-班级信息保存错误: ' .$Course->Klasses()->getError());
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
        var_dump(Request::instance()->post);
    }
}
