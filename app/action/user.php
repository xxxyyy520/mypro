<?php
class userAction extends Action
{
    /**
     * 申请提现
     * @return [type] [description]
     */
    public function charge()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');
        $user   = getModel("user");
        $info   = $user->userinfo("userid=$userid");
        if (isset($_POST) && !empty($_POST)) {
            if ($_POST['sign'] != md5('charge2018')) {
                echo "请求出错！";
                return;
            }
            echo $info['realnamestatus'];
            return;
        } else {
            switch ((int) $info['realnamestatus']) {
                case 1:
                    echo "<script>alert('正在实名审核中！');</script>";
                    break;
                case 2:
                    $orders   = getModel("orders");
                    $banktype = $orders->banktype();
                    $this->tpl->set("bank_name", $banktype[(int) $info["cardtype"]]['name']);

                    $bank_last4 = substr($info["cardid"], -4);
                    $this->tpl->set("bank_last4", $bank_last4);
                    $this->tpl->set("price", $info["price"]);
                    $this->tpl->set("deposit", $info["deposit"]);
                    $this->tpl->display('chargeform.php');
                    break;
                default:
                    $orders   = getModel("orders");
                    $banktype = $orders->banktype();
                    $this->tpl->set("banktype", $banktype);
                    $this->tpl->display('charge.php');
                    break;
            }
        }
    }

    /**
     * 提现确认
     * @return [type] [description]
     */
    public function confirmmoney()
    {
        $this->onlogin();

        if (isset($_POST) && !empty($_POST)) {
            // var_dump($_POST);exit;
            $price  = $_POST['price'];
            $userid = $this->cookie->get('userid');
            $user   = getModel("user");
            $info   = $user->confirmmoney("userid=$userid&price=$price");
            if ($info == -1) {
                echo "<script>alert('26号之后不能提现！');javascript:history.back(-1);</script>";
            } elseif ($info == 0) {
                echo "<script>alert('您本月已经申请过了！');javascript:history.back(-1);</script>";
            } else {
                $tourl = S_ROOT;
                echo "<script>alert('提交成功！');window.location.href='$tourl';</script>";
            }
        }
    }

    /**
     * 实名认证
     * @return [type] [description]
     */
    public function realname()
    {
        if (isset($_POST) && !empty($_POST)) {
            $type = $_POST['type'];
            if ($type == 0) {
                $this->uploadimg($_FILES['certfilea'], 0);
                $this->uploadimg($_FILES['certfileb'], 0);
            } else {
                $this->uploadimg($_FILES['certfile'], 1);
            }

            $user   = getModel("user");
            $userid = $this->cookie->get('userid');
            $user->realname("userid=$userid");

            $tourl = S_ROOT;
            echo "<script>alert('提交成功！');window.location.href='$tourl';</script>";
        }
    }

    /**
     * 上传图片
     * @param  [type] $file [文件]
     * @param  [type] $type [上传的是身份证0，还是营业执照1]
     * @return [type]       [description]
     */
    public function uploadimg($file, $type)
    {
        $imgDir = 'data/cache/';
        if (!is_dir($imgDir)) {
            mkdir($imgDir, 0777, ture);
        }

        $uploader          = getFunc("upload");
        $uploader->path    = $imgDir; //上传路径
        $uploader->maxSize = "3072000"; //文件可传大小
        $uploader->upType  = "jpg|gif|png"; //文件类型

        $res       = $uploader->upload($file);
        $file_name = $uploader->upFile;

        //将图片上传到Alioss
        include_once LIB . 'alioss/upload.php';
        $alioss   = new Alioss();
        $filedir  = UPFILE . "cache/";
        $ossfile  = "data/" . date("Y") . "/" . date("m") . "-" . date("d") . "/" . $file_name;
        $filePath = "." . $filedir . $file_name;
        $alioss->uploadFile($filePath, $ossfile);
        @unlink($filePath); //删除本地服务器的图片，本地相当于一个临时的目录

        if ($res) {
            $user   = getModel("user");
            $userid = $this->cookie->get('userid');
            if ($type == 0) {
                $info = $user->userinfo("userid=$userid");
                if ($info['imgpath'] != '') {
                    $imgpath = $info['imgpath'] . ';' . $ossfile;
                } else {
                    $imgpath = $ossfile;
                }
            } else {
                $imgpath = $ossfile;
            }
            $user->updateuserimg("userid=$userid&imgpath=$imgpath");

            return true;
        } else {
            return false;
        }
    }

    /**
     * 个人中心
     * @return [type] [description]
     */
    public function ucenter()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');

        $user = getModel("user");
        if (isset($_POST) && !empty($_POST)) {
            $info = $user->userinfo("userid=$userid");
            // var_dump($info);
            echo $info['realnamestatus'];
            return;
        } else {
            //获取推荐人
            $name = $user->getreferrer("userid=$userid");
            $this->tpl->set("name", $name); //推荐人

            $info = $user->getuser("userid=$userid");
            $this->tpl->set("info", $info);

            switch ((int) $info['agencylevel']) {
                case 1:
                    $agencylevel = '铁杆会员';
                    break;
                case 2:
                    $agencylevel = '铜牌会员';
                    break;
                case 3:
                    $agencylevel = '银牌会员';
                    break;
                case 4:
                    $agencylevel = '金牌会员';
                    break;
                case 5:
                    $agencylevel = '铂金会员';
                    break;
                case 6:
                    $agencylevel = '钻石会员';
                    break;
                default:
                    $agencylevel = '普通会员';
            }
            $this->tpl->set("agencylevel", $agencylevel);

            $userinfo = $user->userinfo("userid=$userid");
            $this->tpl->set("userinfo", $userinfo);
            $this->tpl->display('ucenter.php');
        }
    }

    public function chargerealname()
    {
        $orders   = getModel("orders");
        $banktype = $orders->banktype();
        $this->tpl->set("banktype", $banktype);
        $this->tpl->display('charge.php');
    }

    /**
     * 粉丝
     * @return [type] [description]
     */
    public function fans()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');

        if ($_GET['level'] === null || $_GET['level'] == '7') {
            $level = '7';
        } else {
            $level = $_GET['level'];
        }
        $this->tpl->set("level", $level);

        $user = getModel("user");
        $num  = $user->getfansnum("userid=$userid");
        $this->tpl->set("num", $num);

        $rows = $user->getfans("userid=$userid&level=$level");
        // var_dump($rows);
        $this->tpl->set("list", $rows["record"]);
        $this->tpl->set("pages", $rows["pages"]);
        $this->tpl->display('fans.php');
    }

    /**
     * 订单中心
     * @return [type] [description]
     */
    public function orderslist()
    {
        $this->onlogin();
        $userid = $this->cookie->get('userid');

        $user = getModel("user");
        $rows = $user->getmyorders("userid=$userid");
        // var_dump($rows);
        $this->tpl->set("list", $rows["record"]);
        $this->tpl->set("pages", $rows["pages"]);
        $this->tpl->display('orderslist.php');
    }

    /**
     * 下单(下单商城)
     * @return [type] [description]
     */
    public function ordersplist()
    {
        $this->onlogin();

        $orders = getModel("orders");
        $lists  = $orders->getproduct();
        $this->tpl->set("lists", $lists);

        $this->tpl->display('ordersplist.php');
    }

    /**
     * 下单成功
     * @return [type] [description]
     */
    public function ordersmsg()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');

        if (isset($_POST) && !empty($_POST)) {
            // var_dump($_POST);exit;

            $user = getModel("user");
            //有无此会员信息
            $customs = $user->get_customs("userid=$userid");
            if ($customs) {
                $customsid = (int) $customs["customsid"];
            } else {
                //录入客户信息
                $user->insert_customs();
                $customsid = (int) $this->db->getLastInsId(); //会员ID
            }

            $orders = getModel("orders");
            //写入订单
            $ordersid = $orders->insert_order("customsid=$customsid");

            if ($_POST['paytype'] == 'weixin') {
                if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
                    $urlto = "https://test.shui.cn/pay/weixin/orders?id=$ordersid";
                } else {
                    $urlto = "https://pay.shui.cn/weixin/orders?id=$ordersid";
                }
            }
            header("location:$urlto");
        }

        $this->tpl->display('ordersmsg.php');
    }

    /**
     * 下单
     * @return [type] [description]
     */
    public function orders()
    {
        $this->onlogin();

        $encoded = $_GET['encoded'];
        $this->tpl->set("encoded", $encoded);

        $orders = getModel("orders");
        $row    = $orders->productinfo("encoded=$encoded");
        $this->tpl->set("info", $row);
        // var_dump($row);

        $this->tpl->display('orders.php');
    }

    /**
     * 等级申请
     * @return [type] [description]
     */
    public function reg()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');
        $user   = getModel("user");
        $row    = $user->userstatus("userid=$userid");
        // var_dump($row);
        $status = (int) $row['status'];

        $this->tpl->set("status", $status);
        $this->tpl->display('reg.php');
    }

    /**
     * 申请登记
     * @return [type] [description]
     */
    public function regform()
    {
        $this->onlogin();

        if (isset($_POST) && !empty($_POST)) {
            // var_dump($_POST);
            $userid = $this->cookie->get('userid');
            $user   = getModel("user");
            $res    = $user->confirmapply("userid=$userid");
            if ($res == 1) {
                $tourl = S_ROOT . 'user/reg';
                echo "<script>alert('提交成功！');window.location.href='$tourl';</script>";
            } else {
                echo "<script>alert('出错！');javascript:history.back(-1);</script>";
            }
        } else {
            $this->tpl->display('regform.php');
        }

    }

    /**
     * 收入明细
     * @return [type] [description]
     */
    public function wallet()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');

        $level = $_GET['level'] ? $_GET['level'] : 'all';
        $this->tpl->set("level", $level);

        $user = getModel("user");
        //总收益
        $totalearning = $user->totalearning("userid=$userid");
        $this->tpl->set("totalearning", $totalearning);
        //今日收益
        $today = $user->totalearning("userid=$userid&today=today");
        // var_dump($today);
        $this->tpl->set("today", $today);

        $rows = $user->earninglist("userid=$userid&level=$level");
        // var_dump($rows['record']);
        $this->tpl->set("list", $rows["record"]);
        $this->tpl->set("pages", $rows["pages"]);
        $this->tpl->display('wallet.php');
    }

    /**
     * 排行榜
     * @return [type] [description]
     */
    public function salestop()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');

        $time = $_GET['time'] ? $_GET['time'] : 'week';
        $this->tpl->set("time", $time);

        $user = getModel("user");
        $rows = $user->ranking("userid=$userid&time=$time");
        // var_dump($rows);
        $this->tpl->set("ranking", $rows);

        $this->tpl->display('salestop.php');
    }

}
