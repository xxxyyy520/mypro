<?php

class authorAction extends Action
{
    Public Function app()
    {
        $do = $_GET["do"]; //判断
        require(CONFIG.'authconfig.php');
        $userid     = (int)$_GET["userid"];
        $username   = $_GET["username"];
        $source     = urldecode($_GET["source"]);
        $dateline   = $_GET["dateline"];
        $token      = $_GET["token"];
        $source = "appid=".AUTHOR_APPID."&appkey=".AUTHOR_APPKEY."&userid=".$userid."&username=".$username."&source=".$source."&dateline=".$dateline."&token=".$token;
        //echo $source;
        if($this->author->checksafe($source))   //判断有效性
        {
            $urlto = $this->cookie->get("urlto");
            $this->author->sync("userid=".$userid."&username=".$username."&source=".$source);   //同步登录
            //处理过程逻辑
            if($do=="sync"){
                echo "1";
            }else{
                if(!$urlto){
                    $urlto = S_ROOT;
                }
                $this->cookie->set("urlto","");
                header("location:$urlto");exit;
                //msgbox($urlto,"",0);
            }
        }else{
            if($do=="sync"){
                $this->author->logout();
                echo "0";
            }else{
                $urlstr = "appid=".AUTHOR_APPID."&source=1jcn&callback=".urlencode(AUTHOR_CALLBACK);    //传递参数请求类型，APPID，回调页面
                $urlto = AUTHOR_REQUEST."?".$urlstr;
                //echo "登录授权超时，请尝试重新登录....";exit;
                dialog("网络响应过慢，正尝试重新登录....");
            }
        }
    }

    //用户登录请求
    public function login()
    {
        require CONFIG.'authconfig.php';
        if ($_GET['urlto']) {
            $urlto = urldecode($_GET['urlto']);
        } else {
            $urlto = $this->cookie->get('urlto');
            if(!$urlto) {
                $urlto = 'https://'.plugin::getHost().S_ROOT;
            }
        }
        $sign = $this->author->checked();
        if (!$sign) {
            $this->cookie->set('urlto', $urlto);    //记录回调地址
            $urlstr = 'appid='.AUTHOR_APPID.'&source=1jcn&backurl='.urlencode(AUTHOR_CALLBACK);    //传递参数请求类型，APPID，回调页面
            //echo $urlstr;exit;
            $urlto = $authconfig['request'].'?'.$urlstr;
        }

        header("location:$urlto");exit;
        //msgbox($urlto, '', 0);
    }


    //用户退出操作
    public function logout()
    {
        if ($_GET['urlto']) {
            $urlto = urldecode($_GET['urlto']);
        } else {
            $urlto = $this->cookie->get('urlto');
            if (!$urlto) {
                $urlto = 'http://'.plugin::getHost().S_ROOT;
            }
        }
        $sign = $this->author->checked();
        if ($sign) {
            $this->author->logout();
        }
        header("location:$urlto");exit;
        msgbox($urlto, '', 0);
    }

    //用户登录状态
    public function checked()
    {
        $sign = $this->author->checked();
        if (!$sign) {
            return false;
        }

        return true;
    }
}
