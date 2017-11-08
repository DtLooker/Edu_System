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
    public function Teacher()
    {
        return $this->belongsTo('Teacher');
    }
}
