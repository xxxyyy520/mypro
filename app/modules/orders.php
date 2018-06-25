<?php
class ordersModules extends Modules
{
    /**
     * 订单详情
     * @return [type]      [description]
     */
    public function ordersinfo($str = "")
    {
        parse_str($str);
        $ordersid = (int) $ordersid;

        $query = " SELECT o.id,o.name,o.mobile,o.address,o.delivertype,o.dateline,o.checked,o.paystate,
        o.status,o.price AS allprice,i.title,i.price
        FROM " . DB_ORDERS . ".orders AS o
        INNER JOIN " . DB_ORDERS . ".ordersinfo AS i ON i.ordersid = o.id
        WHERE o.id = $ordersid ";
        $info = $this->db->getRow($query);

        return $info;
    }

    /**
     * 修改订单
     * @return [type]      [description]
     */
    public function modifiedorders($str = "")
    {
        parse_str($str);

        $arr                = array();
        $arr['delivertype'] = (int) $type;

        $where       = array();
        $where["id"] = (int) $ordersid;

        $this->db->update(DB_ORDERS . ".orders", $arr, $where);

        return 1;
    }

    /**
     * 获取产品列表
     * @return [type] [description]
     */
    public function getproduct()
    {
        $product = [
            [
                'img'       => 'https://alifuwu.shui.cn/images/weapps/x1.jpg',
                'title'     => 'HIOUS 台上式速热净饮机（X1）',
                'encoded'   => '008864',
                'priceone'  => 1460,
                'priceinfo' => '租金 2元/天',
            ],
        ];
        return $product;
    }

    /**
     * 产品详情
     * @return [type] [description]
     */
    public function productinfo($str = "")
    {
        parse_str($str);

        $query = " SELECT productid,title,price_sales,encoded FROM " . DB_PRODUCT . ".product
        WHERE encoded = '$encoded' ";
        $info = $this->db->getRow($query);

        return $info;
    }

    /**
     * 写入订单信息
     * @return [type] [description]
     */
    public function insert_order($str = "")
    {
        parse_str($str);
        extract($_POST);

        //生成订单流水号
        $randstr  = str_pad(substr(time(), -3), 3, "0", STR_PAD_LEFT) . rand(0, 9);
        $ordernum = date("YmdHis", time()) . $randstr; //请与贵网站订单系统中的唯一订单号匹配

        if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
            $price = 0.01;
        } else {
            $price = $_POST['priceone'];
        }

        $arr = array(
            'ordernum'     => $ordernum, //流水号
            'source'       => 'partner', //来源
            'type'         => 10,
            'ctype'        => 3,
            'customsid'    => (int) $customsid,
            'name'         => trim($_POST["name"]),
            'provid'       => (int) $_POST["provid"],
            'cityid'       => (int) $_POST["cityid"],
            'areaid'       => (int) $_POST["areaid"],
            'address'      => trim($_POST["address"]),
            'mobile'       => trim($_POST["mobile"]),
            'price_all'    => $price,
            'price'        => $price,
            'price_setup'  => 0, //安装费用
            'price_minus'  => 0, //优惠费用
            'price_other'  => 0, //其它费用
            'price_detail' => "", //价格说明
            'paytype'      => 2, //支付方式,2网上支付
            'setuptype'    => 4, //安装方式
            'delivertype'  => (int) $_POST["type"], //送货方式
            'detail'       => '', //用户备注
            'salesid'      => 102,
            'afterid'      => 10,
            'datetime'     => date("Y-m-d", time()), //订购时间
            'plansend'     => date("Y-m-d", time() + 86400 * 3), //计划送货时间
            'plansetup'    => date("Y-m-d", time() + 86400 * 3), //计划安装时间
            'dateline'     => time(), //订单生成时间
        );
        $this->db->insert(DB_ORDERS . ".orders", $arr);

        $ordersid = (int) $this->db->getLastInsId(); //获取订单号

        if ($userid = (int) $this->cookie->get('userid')) {
            $arr3 = array(
                'ordersid' => (int) $ordersid,
                'userid'   => $userid,
                'dateline' => time(),
            );
            $this->db->insert(DB_ORDERS . ".bind_users", $arr3);
        }

        $arr1 = array(
            'ordersid'  => $ordersid,
            'productid' => (int) $_POST["productid"],
            'encoded'   => $_POST["encoded"],
            'price'     => $price,
            'grouped'   => 1,
            'title'     => $_POST["title"],
            'nums'      => 1,
            'detail'    => "",
        );
        $this->db->insert(DB_ORDERS . ".ordersinfo", $arr1);

        $arr2 = array(
            'ordersid' => (int) $ordersid,
            'yunid'    => (int) $userid,
            'salesid'  => 102,
            'userid'   => (int) $userid,
            'dateline' => time(),
        );
        $this->db->insert(DB_ORDERS . ".yun_share", $arr2);

        return $ordersid;
    }

    /**
     * 配送方式
     * @return [type] [description]
     */
    public function delivertype()
    {
        $ds    = array();
        $ds[1] = array('id' => '1', 'name' => '送货上门', 'img' => '');
        $ds[2] = array('id' => '2', 'name' => '委托发货', 'img' => '');
        $ds[3] = array('id' => '3', 'name' => '自行取货', 'img' => '');
        $ds[4] = array('id' => '4', 'name' => '第三方配送', 'img' => '');
        $ds[5] = array('id' => '5', 'name' => '其它', 'img' => '');
        return $ds;
    }

    /**
     * 订单状态
     * @return [type] [description]
     */
    public function statustype()
    {
        $ds    = array();
        $ds[0] = array('id' => '0', 'name' => '等待审核', 'color' => 'blue', 'next' => '0,2,5');
        $ds[2] = array('id' => '2', 'name' => '等待处理', 'color' => 'orange', 'next' => '2,3,4,5,7');
        //$ds[3]    = array('id' =>'3',    'name'    => '等待收货',    'color'    =>    'orange',    'next'    =>    '3,4,5,6,7');
        //$ds[4]    = array('id' =>'4',    'name'    => '等待送货',    'color'    =>    'orange',    'next'    =>    '4,5,6,7');
        $ds[5] = array('id' => '5', 'name' => '等待安装', 'color' => 'orange', 'next' => '5,6,7');
        $ds[6] = array('id' => '6', 'name' => '完成确认', 'color' => 'orange', 'next' => '6,1');
        $ds[7] = array('id' => '7', 'name' => '等待取消', 'color' => 'orange', 'next' => '7,8,-1');
        //$ds[8]    = array('id' =>'8',    'name'    => '等待退款',    'color'    =>    'orange',    'next'    =>    '8,-1');
        $ds[1]  = array('id' => '1', 'name' => '订单完成', 'color' => 'green', 'next' => '');
        $ds[-1] = array('id' => '-1', 'name' => '订单作废', 'color' => 'green', 'next' => '');
        return $ds;
    }

    /**
     * 银行种类
     * @return [type] [description]
     */
    public function banktype()
    {
        $ds     = array();
        $ds[1]  = array('id' => '1', 'name' => '中国银行');
        $ds[2]  = array('id' => '2', 'name' => '农业银行');
        $ds[3]  = array('id' => '3', 'name' => '招商银行');
        $ds[4]  = array('id' => '4', 'name' => '工商银行');
        $ds[5]  = array('id' => '5', 'name' => '中信银行');
        $ds[6]  = array('id' => '6', 'name' => '建设银行');
        $ds[7]  = array('id' => '7', 'name' => '广发银行');
        $ds[8]  = array('id' => '8', 'name' => '光大银行');
        $ds[9]  = array('id' => '9', 'name' => '邮政储蓄银行');
        $ds[10] = array('id' => '10', 'name' => '交通银行');
        return $ds;
    }

}
