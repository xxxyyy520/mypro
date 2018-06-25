<?php
class productAction extends Action
{
    /**
     * 产品海报
     * @return [type] [description]
     */
    public function poster()
    {
        $this->onlogin();
        $article = getModel("article");

        if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
            $parentid = '1382';
        } else {
            $parentid = '1388';
        }
        $row = $article->gettopic("parentid=$parentid");
        // var_dump($row);
        $this->tpl->set("topicrows", $row);

        $topicid = ($_GET['topicid']) ? $_GET['topicid'] : $row[0]['topic'];
        // echo $topicid;
        $row = $article->getarticle("topicid=$topicid");
        // var_dump($row);
        $this->tpl->set("topicid", $topicid);
        $this->tpl->set("articlerows", $row);

        $this->tpl->display('poster.php');
    }

    /**
     * 生成产品图片
     * @return [type] [description]
     */
    public function creatposter()
    {
        $this->onlogin();

        if (isset($_POST) && !empty($_POST)) {
            // var_dump($_POST);exit;
            $userid    = $this->cookie->get('userid');
            $articleid = $_POST['articleid'];
            // echo $articleid;
            $article = getModel("article");
            $info    = $article->getarticleinfo("articleid=$articleid");
            // var_dump($info['urlto']);
            if (!$info['urlto']) {
                echo 0;
                exit;
            }
            if (strpos($info['urlto'], '?') === false) {
                $urlto = urlencode($info['urlto'] . "?agentId=$userid");
            } else {
                $urlto = urlencode($info['urlto'] . "&agentId=$userid");
            }
            $url = 'https://api.shui.cn/qrcode?data=' . urlencode($urlto);
            // echo $url;exit;

            $poster_arr = array(
                "userid"        => $userid,
                "source_thumb"  => "https://file.shui.cn" . $info['pic'],
                "qrcode_thumb"  => $url,
                "qrcode_width"  => 200,
                "qrcode_height" => 200,
                "text"          => '扫描/长按识别图中二维码',
                "type"          => 0,
            );
            // var_dump($poster_arr);exit;
            $curl       = getFunc("curl");
            $poster_pic = $curl->contents("http://api.shui.cn/poster", $poster_arr);
            if ($poster_pic) {
                echo $poster_pic;
            } else {
                echo 0;
            }
            exit;
        }
    }

    /**
     * 专属海报
     * @return [type] [description]
     */
    public function qrcode()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');
        $curl   = getFunc("curl");
        $url    = "https://we.shui.cn/api?source=yun&type=103&sceneid=$userid&userid=28646";
        $res    = $curl->contents($url);

        $res = json_decode($res, true);
        // var_dump($res);
        $qrcode_thumb = $res['image'];
        // var_dump($qrcode_thumb);exit;
        //测试服务器地址
        if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
            $source_thumb = 'https://' . $_SERVER['HTTP_HOST'] . '/partner/images/poster.jpg';
        } else {
            $source_thumb = 'https://' . $_SERVER['HTTP_HOST'] . '/images/poster.jpg';
        }
        //两张图片格式要一样,强行更改的图片格式也不能生成
        $poster_arr = array(
            "userid"        => $userid,
            "source_thumb"  => $source_thumb,
            "qrcode_thumb"  => $qrcode_thumb,
            "qrcode_width"  => 200,
            "qrcode_height" => 200,
            "text"          => '扫描/长按识别图中二维码',
            "type"          => 0,
        );
        // var_dump($poster_arr);
        $poster = $curl->contents("http://api.shui.cn/poster", $poster_arr);
        // var_dump($poster);
        $this->tpl->set("poster", $poster);
        $this->tpl->display('qrcode.php');
    }

    /**
     * 全部销售
     * @return [type] [description]
     */
    public function sales()
    {
        $this->onlogin();

        $userid = $this->cookie->get('userid');

        $level = $_GET['level'] ? $_GET['level'] : 'all';
        $this->tpl->set("level", $level);

        $user = getModel("user");
        $rows = $user->getsaleslist("userid=$userid&level=$level");

        $row = $user->gettodaysales("userid=$userid");
        // var_dump($row);
        $today = $row ? $row['num'] : 0;
        $total = $rows ? $rows["total"] : 0;
        $this->tpl->set("today", $today);
        $this->tpl->set("total", $total);
        $this->tpl->set("list", $rows["record"]);
        $this->tpl->set("pages", $rows["pages"]);
        $this->tpl->display('sales.php');
    }

    /**
     * 订单详情
     * @return [type] [description]
     */
    public function ordersinfo()
    {
        $this->onlogin();
        $ordersid = base64_decode($_GET['id']);
        // echo $ordersid;
        $orders = getModel("orders");
        //配送方式
        $delivertype = $orders->delivertype();
        $this->tpl->set("delivertype", $delivertype);

        //订单状态
        $statustype = $orders->statustype();
        $this->tpl->set("statustype", $statustype);

        $info = $orders->ordersinfo("ordersid=$ordersid");
        // var_dump($info);
        $this->tpl->set("info", $info);
        $this->tpl->display('ordersinfo.php');
    }

    /**
     * 修改订单
     * @return [type] [description]
     */
    public function modified()
    {
        $this->onlogin();
        $orders = getModel("orders");

        if (isset($_POST) && !empty($_POST)) {
            $ordersid = base64_decode($_POST['ordersid']);
            // echo $ordersid;
            $type = $_POST['type'];
            $info = $orders->ordersinfo("ordersid=$ordersid");
            if (((int) $info['status'] == 0) && ((int) $info['checked'] == 0)) {
                // var_dump($ordersid);exit;
                $orders->modifiedorders("ordersid=$ordersid&type=$type");
                $tourl = S_ROOT.'product/ordersinfo?id='.$_POST['ordersid'];
                echo "<script>alert('修改成功！');window.location.href='$tourl';</script>";
            } else {
                echo "<script>alert('该订单不可修改！');</script>";
            }
        } else {
            $ordersid = base64_decode($_GET['id']);
            // echo $ordersid;
            //订单状态
            $statustype = $orders->statustype();
            $this->tpl->set("statustype", $statustype);

            $info = $orders->ordersinfo("ordersid=$ordersid");
            // var_dump($info);
            $this->tpl->set("info", $info);
            $this->tpl->display('ordersinfo2.php');
        }
    }

    /**
     * 发票信息
     * @return [type] [description]
     */
    public function fapiao()
    {
        $this->onlogin();

        $this->tpl->display('fapiao.php');
    }

}
