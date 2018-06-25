<?php
class indexAction extends Action
{

    public function app()
    {
        $this->onlogin();
        $userid = $this->cookie->get('userid');
        $user   = getModel("user");
        $rows   = $user->userinfo("userid=$userid");
        // var_dump($rows);exit;
        //如果无此用户信息
        if ($rows == 1) {
            //获取推荐人(关系表是否有此人记录)
            $res = $user->getreferrer("userid=$userid");
            if ($res === false) {
                //无此人记录，跳转
                $article = getModel("article");

                if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
                    $articleid = '4488';
                } else {
                    $articleid = '4558';
                }
                $rows = $article->getarticleinfo("articleid=$articleid");
                // var_dump($rows);
                $this->tpl->set("rows", $rows);
                $this->tpl->display('article.views.php');
            } else {
                $user->insertuser("userid=$userid");
                $this->userinfo();
            }
        } else {
            $this->userinfo();
        }
    }

    public function userinfo()
    {
        $userid = $this->cookie->get('userid');
        $user   = getModel("user");
        $row    = $user->ismembers("userid=$userid");
        // var_dump($row);exit;
        //获取推荐人
        $name = $user->getreferrer("userid=$userid");
        $this->tpl->set("name", $name); //推荐人

        if ($row == 1 || $row == 2) {
            $rows = $user->userinfo("userid=$userid");
            switch ((int) $rows['agencylevel']) {
                case 1:
                    $agencylevel = '铁杆会员';
                    $level       = 1;
                    break;
                case 2:
                    $agencylevel = '铜牌会员';
                    $level       = 2;
                    break;
                case 3:
                    $agencylevel = '银牌会员';
                    $level       = 3;
                    break;
                case 4:
                    $agencylevel = '金牌会员';
                    $level       = 4;
                    break;
                case 5:
                    $agencylevel = '铂金会员';
                    $level       = 5;
                    break;
                case 6:
                    $agencylevel = '钻石会员';
                    $level       = 6;
                    break;
                default:
                    $agencylevel = '普通会员';
                    $level       = 0;
            }
            $wallet = floatval($rows['price'] + $rows['deposit']);

            $all_get_money = $user->totalearning("userid=$userid"); //总收益

            $today_get_money = $user->totalearning("userid=$userid&today=today"); //今日收益

            $imglevel = $level + 1;
            $faceurl  = $rows['faceurl'] ? $rows['faceurl'] : S_ROOT . 'images/avatar/avatar-0' . $imglevel . '.jpg';
            $this->tpl->set("agencylevel", $agencylevel); //会员级别
            $this->tpl->set("faceurl", $faceurl); //会员头像
            $this->tpl->set("wallet", $wallet); //余额
            $this->tpl->set("level", $level); //根据级别改变样式
            $this->tpl->set("all_get_money", $all_get_money); //总收益
            $this->tpl->set("today_get_money", $today_get_money); //今日收益
            $this->tpl->display('home.php');
        } else {
            //无此人记录，跳转
            $article = getModel("article");

            if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
                $articleid = '4488';
            } else {
                $articleid = '4558';
            }
            $rows = $article->getarticleinfo("articleid=$articleid");
            // var_dump($rows);
            $this->tpl->set("rows", $rows);
            $this->tpl->display('article.views.php');
        }
    }

}
