<?php
namespace app\common\validate;

use think\Validate;

/**
 文件的位置必须放在application\common\validate 下，并且，必须和我们的数据表模型名称一致。
 文件的位置必须放在因为只有这样，thinkphp这个框架才能找到它。
 */
class Teacher extends Validate
{
    protected $rule = [
        'username' => 'require|unique:teacher|length:4,25',
        'name' => 'require|length:2,25',
        'sex' => 'in:0,1',
        'email' => 'email',
    ];
}
