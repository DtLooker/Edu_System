<?php
namespace app\common\model;

use think\Model;

/**
 * 课程
 */
class Course extends Model
{
    /**
     * 多对多关联
     */
    public function Klasses()
    {
        return $this->belongsToMany('Klass', config('database.prefix').'klass_course');
    }

    /**
     * 获取是否存在相关关联记录
     * @param  Klass  $klass [description]
     * @return [type]        [description]
     */
    public function getIsChecked(Klass &$klass)
    {
        //取课程ID
        $courseId = (int)$this->id;
        $klassId = (int)$Klass->id;
        //定制查询条件
        $map = array();
        $map['klass_id'] = $klassId;
        $map['course_id'] = $courseId;
        //从关联表中取信息
        $KlassCourse = KlassCourse::get($map);
        //有记录，返回true；没记录，返回false
        if (is_null($KlassCourse)) {
            return false;
        } else {
            return true;
        }
    }
}
