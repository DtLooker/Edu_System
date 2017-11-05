<?php
namespace app\common\model;

use think\Model;

/**
 * 教师表
 */
class Teacher extends Model
{
    /**
     * 用户登录
     * @param  [string] $username [用户名]
     * @param  [string] $password [密码]
     * @return [bool]           [成功返回true，失败返回false]
     */
    public static function login($username, $password)
    {
        //验证用户是否存在
        $map = array('username' => $username);
        $Teacher = self::get($map);

        if (!is_null($Teacher)) {
            //验证密码是否正确
            if ($Teacher->checkPassword($password)) {
                //登录
                session('teacherId', $Teacher->getData('id'));
                return true;
            }
        }
        return false;
    }

    /**
     * 验证密码是否正确
     * @param  [string] $password [密码]
     * @return [bool]
     */
    public function checkPassword($password)
    {
        if ($this->getData('password') === $this::encryptPassword($password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * [密码加密算法]
     * @param  [string] $password [加密前密码]
     * @return [string]           [加密后密码]
     */
    public static function encryptPassword($password)
    {
        //实际过程中，我们可以借助不同支付穿算法，实现不同加密
        return sha1(md5($password) . 'looker');
    }
}
