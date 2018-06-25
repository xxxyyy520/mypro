<?php
abstract class Action
{

    public $tpl = null;
    public $msg = null;

    //+--------------------------------------------------------------------------------------------
    //Desc:类的构造子(对象初始化)
    public function __construct()
    {
        $this->author = getModel("author");
    }

    //+--------------------------------------------------------------------------------------------
    //Desc:类的析构方法(负责资源的清理工作)
    public function __destruct()
    {
        $this->tpl = null;
        $this->msg = null;
    }
    //+---------------------------------------------------------------------------------------------
    //Desc::判断用户登录状态
    public function onlogin()
    {
        $sign = $this->author->checked();
        if (!$sign) {
            $backurl = plugin::getURL();
            $urlto   = S_ROOT . "author/login?urlto=" . urlencode($backurl); //echo $backurl;exit();
            header("location:$urlto");
            exit();
        } else {
            $this->userinfo();
        }
    }

    public function userinfo()
    {
        if ($this->author->checked()) {
            //用户ID
            $userid = $this->cookie->get("userid");
            $this->tpl->set("userid", $userid);
            //用户名称
            $username = $this->cookie->get("username");
            $this->tpl->set("username", $username);
            //用户信息
            $author   = getModel("author");
            $userinfo = $author->userinfo("userid=$userid");
            $this->tpl->set("userinfo", $userinfo);
        }
    }

}
