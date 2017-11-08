<?php
namespace app\common\model;

use think\Model;

/**
 * 学生表
 */
class Student extends Model
{
    protected $dateFormat = 'Y年m月d日';//日期格式
    /**
     * 自定义自转换
     * @var [array]
     */
    protected $type = [
        'create_time' => 'datetime',
    ];

    /**
     * 输出性别的属性
     * @param  [type] $value [description]
     * @return [string]        [0男，1女]
     */
    public function getSexAttr($value)
    {
        $status = array('0'=>'男', '1'=>'女');
        $sex = $status[$value];
        if (isset($sex)) {
            return $sex;
        } else {
            return $status[0];
        }
    }

    /**
     * ThinkPHP使用一个叫做__get()的魔法函数来完成这个函数的自动调用
     */
    public function Klass()
    {
        return $this->belongsTo('Klass');
    }
}
