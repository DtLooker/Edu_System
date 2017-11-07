<?php
namespace app\common\model;

use think\Model;

/**
 * 班级
 */
class Klass extends Model
{
    private $Teacher;
    /**
     * 获取对应教师（辅导员）信息
     * @return [type] [description]
     */
    public function getTeacher()
    {
        if (is_null($this->Teacher)) {
            $teacherId = $this->getData('teacher_id');
            $this->Teacher = Teacher::get($teacherId);
        }
        return $this->Teacher;
    }
}
