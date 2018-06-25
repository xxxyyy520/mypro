<?php
class userModules extends Modules
{
    /**
     * 获取用户信息
     * @param  string $str [description]
     * @return [type]      [description]
     */
    public function userinfo($str = "")
    {
        parse_str($str);
        $userid = (int) $userid;

        $query = " SELECT price,agencylevel,deposit,realnamestatus,imgpath,cardtype,cardid,identityid,cardname
        FROM " . DB_ORDERS . ".yun_users WHERE userid = $userid ";
        $info = $this->db->getRow($query);

        //合伙人表里无此人记录
        if (!$info) {
            return 1;
        }

        $query = " SELECT faceurl FROM " . DB_MEMBERS . ".bind_weixin
        WHERE userid = $userid AND faceurl is not NULL ";
        $row = $this->db->getRow($query);
        if ($row) {
            $info['faceurl'] = $row['faceurl'];
        } else {
            $info['faceurl'] = '';
        }

        return $info;
    }

    /**
     * 写入新用户
     * @return [type]      [description]
     */
    public function insertuser($str = "")
    {
        $arr             = array();
        $arr["userid"]   = $userid;
        $arr["dateline"] = time();
        $this->db->insert(DB_ORDERS . ".yun_users", $arr);
        return 1;
    }

    /**
     * 获取推荐人
     * @return [type] [description]
     */
    public function getreferrer($str = "")
    {
        parse_str($str);
        $userid = (int) $userid;

        $query = " SELECT parentuserid FROM " . DB_B2B . ".relationship WHERE userid = $userid ";
        $info  = $this->db->getRow($query);
        // return $info;
        if ($info) {
            $author       = getModel("author");
            $parentuserid = (int) $info['parentuserid'];
            $query        = " SELECT username,name FROM " . DB_ORDERS . ".yun_users WHERE userid = $parentuserid ";
            $row          = $this->db->getRow($query);
            if ($row) {
                $name = $row['username'] ? $row['username'] : $row['name'];
                if (!$name) {
                    $query = " SELECT username FROM " . DB_MEMBERS . ".users WHERE userid = $parentuserid ";
                    $row   = $this->db->getRow($query);
                    $name  = $row['username'];
                }
                return $name;
            }
            return 0; //0为未查到姓名
        }
        //false为关系表里无记录
        return false;
    }

    /**
     * 获取销售列表
     * @return [type] [description]
     */
    public function getsaleslist($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;

        //获取一级粉丝userid
        $sql  = " SELECT userid FROM " . DB_B2B . ".relationship WHERE parentuserid = $userid ";
        $rows = $this->db->getRows($sql);
        //一级粉丝userid
        $one_ary = array();
        if ($rows) {
            foreach ($rows as $value) {
                array_push($one_ary, (int) $value['userid']);
            }
        }

        //2级粉丝userid
        $two_ary = array();
        if (!empty($one_ary)) {
            $str = '';
            foreach ($one_ary as $value) {
                $str .= $value . ',';
            }
            $str = '(' . rtrim($str, ',') . ')';
            // echo $str;exit;
            //获取2级粉丝userid
            $sql = " SELECT userid FROM " . DB_B2B . ".relationship WHERE parentuserid IN $str ";
            // echo $sql;exit;
            $rows = $this->db->getRows($sql);
            // var_dump($rows);
            if ($rows) {
                foreach ($rows as $value) {
                    array_push($two_ary, (int) $value['userid']);
                }
            }
        }
        // var_dump($two_ary);echo "<br><br>";

        $userid_in = '';
        switch ($level) {
            case 'one':
                //没有一级粉丝
                if (empty($one_ary)) {
                    return 0;
                }
                foreach ($one_ary as $value) {
                    $userid_in .= $value . ',';
                }
                $userid_in = '(' . rtrim($userid_in, ',') . ')';
                break;
            case 'two':
                //没有一级或2及粉丝
                if (empty($one_ary) || empty($two_ary)) {
                    return 0;
                }
                foreach ($two_ary as $value) {
                    $userid_in .= $value . ',';
                }
                $userid_in = '(' . rtrim($userid_in, ',') . ')';
                break;
            default:
                //全部记录要加上自己销售的
                array_push($one_ary, $userid);
                $all_userid_ary = array_merge($one_ary, $two_ary); //一级二级粉丝合并
                foreach ($all_userid_ary as $value) {
                    $userid_in .= $value . ',';
                }
                $userid_in = '(' . rtrim($userid_in, ',') . ')';
                // var_dump($all_userid_ary);exit;
                break;
        }
        // echo $userid_in;exit;

        $query = " SELECT o.price,o.id,o.datetime,i.title,o.paystate,
            u.username AS name1,u.name AS name2,us.username AS name3,
            u.agencylevel,o.status,o.checked
            FROM " . DB_ORDERS . ".yun_share AS y
            INNER JOIN " . DB_ORDERS . ".orders AS o ON o.id = y.ordersid
            INNER JOIN " . DB_ORDERS . ".yun_users AS u ON u.userid = y.userid
            INNER JOIN " . DB_ORDERS . ".ordersinfo AS i ON i.ordersid = y.ordersid
            LEFT JOIN " . DB_MEMBERS . ".users AS us ON us.userid = u.userid
            WHERE o.hide = 1 AND i.price > 1 AND y.yunid IN $userid_in
            ORDER BY o.datetime DESC ";
        // echo $query;exit;
        $list = $this->db->getPageRows($query, 10);

        return $list;
    }

    /**
     * 今日销量
     * @param  string $str [description]
     * @return [type]      [description]
     */
    public function gettodaysales($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;

        //获取一级粉丝userid
        $sql  = " SELECT userid FROM " . DB_B2B . ".relationship WHERE parentuserid = $userid ";
        $rows = $this->db->getRows($sql);
        //一级粉丝userid
        $one_ary = array();
        if ($rows) {
            foreach ($rows as $value) {
                array_push($one_ary, (int) $value['userid']);
            }
        }

        //2级粉丝userid
        $two_ary = array();
        if (!empty($one_ary)) {
            $str = '';
            foreach ($one_ary as $value) {
                $str .= $value . ',';
            }
            $str = '(' . rtrim($str, ',') . ')';
            //获取2级粉丝userid
            $sql  = " SELECT userid FROM " . DB_B2B . ".relationship WHERE parentuserid IN $str ";
            $rows = $this->db->getRows($sql);
            if ($rows) {
                foreach ($rows as $value) {
                    array_push($two_ary, (int) $value['userid']);
                }
            }
        }

        //只计算今日销售量就不分一级二级粉丝
        array_push($one_ary, $userid);
        $all_userid_ary = array_merge($one_ary, $two_ary); //一级二级粉丝合并
        foreach ($all_userid_ary as $value) {
            $userid_in .= $value . ',';
        }
        $userid_in = '(' . rtrim($userid_in, ',') . ')';

        $beginDate = date("Y-m-d 00:00:00", time());
        $endDate   = date("Y-m-d 23:59:59", time()); //当天最后一秒时间
        $beginline = strtotime($beginDate);
        $endline   = strtotime("$beginDate+1 day");

        $query = " SELECT COUNT(o.id) AS num
            FROM " . DB_ORDERS . ".yun_share AS y
            INNER JOIN " . DB_ORDERS . ".orders AS o ON o.id = y.ordersid
            INNER JOIN " . DB_ORDERS . ".yun_users AS u ON u.userid = y.userid
            INNER JOIN " . DB_ORDERS . ".ordersinfo AS i ON i.ordersid = y.ordersid
            WHERE o.hide = 1 AND i.price > 1 AND y.dateline >= $beginline AND y.dateline <= $endline AND y.yunid IN $userid_in
            ORDER BY o.datetime DESC ";
        $row = $this->db->getRow($query);

        return $row;
    }

    /**
     * 获取粉丝
     * @return [type] [description]
     */
    public function getfans($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;
        $level  = (int) $level;

        $where = '';
        if ($level != 7) {
            $where = " AND y.agencylevel = $level ";
        }

        //获取一级粉丝userid
        $sql = " SELECT r.userid,r.dateline,y.username AS name1,y.name AS name2,u.username AS name3,y.agencylevel
        FROM " . DB_B2B . ".relationship AS r
        LEFT JOIN " . DB_ORDERS . ".yun_users AS y ON r.userid = y.userid
        LEFT JOIN " . DB_MEMBERS . ".users AS u ON r.userid = u.userid
        WHERE r.parentuserid = $userid $where
        ORDER BY r.dateline DESC ";
        // echo $sql;
        $rows = $this->db->getPageRows($sql, 10);
        if ($rows['record']) {
            foreach ($rows['record'] as $key => $value) {
                $userid = $value['userid'];
                $sql    = " SELECT COUNT(id) AS num FROM " . DB_B2B . ".relationship
                WHERE parentuserid = $userid ";
                $row      = $this->db->getRow($sql);
                $fans_num = $row ? $row['num'] : 0;

                $rows['record'][$key]['fans'] = $fans_num;
            }
        }
        return $rows;
    }

    /**
     * 获取粉丝总数量
     * @return [type] [description]
     */
    public function getfansnum($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;
        //获取一级粉丝userid
        $sql = " SELECT COUNT(id) AS num FROM " . DB_B2B . ".relationship
        WHERE parentuserid = $userid ";
        // echo $sql;
        $row = $this->db->getRow($sql);
        $num = 0;
        if ($row) {
            $num = $row['num'];
        }
        return $num;
    }

    /**
     * 销售收益
     * @return [type] [description]
     */
    public function totalearning($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;

        $where = '';
        if ($today != "") {
            $beginDate = date("Y-m-d 00:00:00", time());
            $endDate   = date("Y-m-d 23:59:59", time()); //当天最后一秒时间
            $beginline = strtotime($beginDate);
            $endline   = strtotime("$beginDate+1 day");
            $where .= " AND dateline >= $beginline AND dateline <= $endline ";
        }

        //获取一级粉丝userid
        $sql = " SELECT SUM(price) AS totalearning FROM " . DB_ORDERS . ".yun_wallet
        WHERE hide = 1 AND ordersid > 0 AND type = 5 AND userid = $userid $where ";
        // echo $sql;
        $row = $this->db->getRow($sql);
        // var_dump($row);
        $totalearning = 0;
        if ($row['totalearning']) {
            $totalearning = $row['totalearning'];
        }
        return $totalearning;
    }

    /**
     * 收益列表
     * @return [type] [description]
     */
    public function earninglist($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;

        //获取一级粉丝userid
        $sql  = " SELECT userid FROM " . DB_B2B . ".relationship WHERE parentuserid = $userid ";
        $rows = $this->db->getRows($sql);

        $one_ary = array(); //一级粉丝userid
        if ($rows) {
            foreach ($rows as $value) {
                array_push($one_ary, (int) $value['userid']);
            }
        }

        //2级粉丝userid
        $two_ary = array();
        if (!empty($one_ary)) {
            $str = '';
            foreach ($one_ary as $value) {
                $str .= $value . ',';
            }
            $str = '(' . rtrim($str, ',') . ')';
            // echo $str;exit;
            //获取2级粉丝userid
            $sql = " SELECT userid FROM " . DB_B2B . ".relationship WHERE parentuserid IN $str ";
            // echo $sql;exit;
            $rows = $this->db->getRows($sql);
            // var_dump($rows);
            if ($rows) {
                foreach ($rows as $value) {
                    array_push($two_ary, (int) $value['userid']);
                }
            }
        }

        $userid_in = '';
        switch ($level) {
            case 'one':
                //没有一级粉丝
                if (empty($one_ary)) {
                    return 0;
                }
                foreach ($one_ary as $value) {
                    $userid_in .= $value . ',';
                }
                $userid_in = '(' . rtrim($userid_in, ',') . ')';
                break;
            case 'two':
                //没有一级或2及粉丝
                if (empty($one_ary) || empty($two_ary)) {
                    return 0;
                }
                foreach ($two_ary as $value) {
                    $userid_in .= $value . ',';
                }
                $userid_in = '(' . rtrim($userid_in, ',') . ')';
                break;
            default:
                //全部记录要加上自己销售的
                array_push($one_ary, $userid);
                $all_userid_ary = array_merge($one_ary, $two_ary); //一级二级粉丝合并
                foreach ($all_userid_ary as $value) {
                    $userid_in .= $value . ',';
                }
                $userid_in = '(' . rtrim($userid_in, ',') . ')';
                break;
        }

        //ys.userid为粉丝userid
        $query = " SELECT ys.userid,yw.dateline,yw.price,
        y.username AS name1,y.name AS name2,u.username AS name3,y.agencylevel
        FROM " . DB_ORDERS . ".yun_wallet AS yw
        INNER JOIN " . DB_ORDERS . ".yun_share AS ys ON ys.ordersid = yw.ordersid
        LEFT JOIN " . DB_ORDERS . ".yun_users AS y ON y.userid = ys.userid
        LEFT JOIN " . DB_MEMBERS . ".users AS u ON y.userid = u.userid
        WHERE yw.type = 5 AND yw.ordersid > 0 AND yw.userid = $userid AND ys.userid IN $userid_in
        GROUP BY yw.id
        ORDER BY yw.dateline DESC ";
        // echo $query;
        $list = $this->db->getPageRows($query, 10);
        return $list;
    }

    /**
     * 我的订单
     * @return [type] [description]
     */
    public function getmyorders($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;

        $query = " SELECT o.price,o.id,o.datetime,i.title,o.paystate,
            u.username AS name1,u.name AS name2,us.username AS name3,
            u.agencylevel,o.status,o.checked
            FROM " . DB_ORDERS . ".yun_share AS y
            INNER JOIN " . DB_ORDERS . ".orders AS o ON o.id = y.ordersid
            INNER JOIN " . DB_ORDERS . ".yun_users AS u ON u.userid = y.userid
            INNER JOIN " . DB_ORDERS . ".ordersinfo AS i ON i.ordersid = y.ordersid
            LEFT JOIN " . DB_MEMBERS . ".users AS us ON us.userid = u.userid
            WHERE o.hide = 1 AND i.price > 1 AND y.yunid = $userid AND y.userid = $userid
            ORDER BY o.datetime DESC ";
        // echo $query;exit;
        $rows = $this->db->getPageRows($query, 10);

        return $rows;
    }

    /**
     * 获取申请状态
     * @return [type] [description]
     */
    public function userstatus($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;

        $query = " SELECT status FROM " . DB_ORDERS . ".yun_users
        WHERE userid = $userid ";
        $row = $this->db->getRow($query);

        return $row;
    }

    /**
     * 代理登记
     * @return [type] [description]
     */
    public function confirmapply($str = "")
    {
        parse_str($str);
        extract($_POST);

        $arr            = array();
        $arr["name"]    = $name;
        $arr['address'] = $address;
        $arr['provid']  = (int) $provid;
        $arr['cityid']  = (int) $cityid;
        $arr['areaid']  = (int) $areaid;
        $arr['mobile']  = $mobile;
        $arr['status']  = 1;

        $where           = array();
        $where["userid"] = $userid;

        $this->db->update(DB_ORDERS . ".yun_users", $arr, $where);

        return 1;
    }

    /**
     * 是否能进入到系统(是否合伙人)
     * @return [type] [description]
     */
    public function ismembers($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;
        $query  = " SELECT agencylevel FROM " . DB_ORDERS . ".yun_users
        WHERE userid = $userid ";
        $row = $this->db->getRow($query);
        if ($row && ((int) $row['agencylevel'] > 0)) {
            return 1; //1为用户等级大于0
        } else {
            $query = " SELECT od.ordersid FROM " . DB_ORDERS . ".bind_users AS bu
                INNER JOIN " . DB_ORDERS . ".orders AS o ON o.id = bu.ordersid
                INNER JOIN " . DB_ORDERS . ".orders_device AS od ON od.ordersid = bu.ordersid
                INNER JOIN " . DB_ORDERS . ".ordersinfo AS oi ON bu.ordersid = oi.ordersid
                WHERE bu.userid = $userid AND o.paystate = 1
                AND oi.encoded IN ('008864','008865','008866') ";
            $row2 = $this->db->getRow($query);
            if ($row2) {
                //修改级别为1，铁杆
                $arr                = array();
                $arr['agencylevel'] = 1;

                $where           = array();
                $where["userid"] = $userid;

                $this->db->update(DB_ORDERS . ".yun_users", $arr, $where);
                return 2; //2为买过X1
            } else {
                return 0;
            }

        }
    }

    /**
     * 实名认证用户的提交及个人信息
     * @return [type] [description]
     */
    public function realname($str = "")
    {
        extract($_POST);
        parse_str($str);

        $userid = (int) $userid;

        //企业
        if ($type == 1) {
            $username   = $username1;
            $identityid = $identityid1;
            $cardtype   = $cardtype1;
            $cardid     = $cardid1;
            $cardname   = $cardname1;
        }

        $arr = array();

        $arr['username']       = $username;
        $arr['identityid']     = $identityid;
        $arr['cardtype']       = $cardtype;
        $arr['cardid']         = $cardid;
        $arr['type']           = (int) $type;
        $arr['cardname']       = $cardname;
        $arr['realnamestatus'] = 1;
        $arr['dateline']       = time();

        $where           = array();
        $where["userid"] = $userid;

        $res = $this->db->update(DB_ORDERS . ".yun_users", $arr, $where);

        return 1;
    }

    /**
     * 更新用户身份证或者营业执照图片
     * @return [type] [description]
     */
    public function updateuserimg($str = "")
    {
        parse_str($str);

        $arr = array();

        $arr["imgpath"] = $imgpath;

        $where           = array();
        $where["userid"] = (int) $userid;

        $this->db->update(DB_ORDERS . ".yun_users", $arr, $where);

        return 1;
    }

    /**
     * 提现申请
     * @return [type] [description]
     */
    public function confirmmoney($str = "")
    {
        parse_str($str);
        $userid = (int) $userid;
        //26号之后不能提现
        $day = (int) substr(date('Y-m-d'), -2);
        if ($day > 26) {
            return -1;
        }

        //本月是否有提现记录
        $beginline = strtotime(date("Y-m-01"));
        $BeginDate = date('Y-m-01', strtotime(date("Y-m-d")));
        $endDate   = date('Y-m-d', strtotime("$BeginDate +1 month"));
        $endline   = strtotime($endDate);
        $query     = " SELECT id FROM " . DB_ORDERS . ".yun_wallet_cash
        WHERE userid = $userid AND dateline > $beginline AND dateline < $endline ";
        $info = $this->db->getRow($query);
        if ($info) {
            return 0;
        }

        $row = $this->userinfo("userid=$userid");
        // var_dump($row);exit;
        $arr              = array();
        $arr['userid']    = $userid;
        $arr['cardid']    = $row['cardid'];
        $arr['price']     = floatval($price);
        $arr['priceinfo'] = "合伙人提现";
        $arr['dateline']  = time();

        $res = $this->db->insert(DB_ORDERS . ".yun_wallet_cash", $arr);
        return 1;
    }

    /**
     * 排行榜
     * @return [type] [description]
     */
    public function ranking($str = "")
    {
        parse_str($str);
        $userid = (int) $userid;

        if ($time == 'week') {
            $rows = [
                ['userid' => '1', 'allsales' => 3500, 'name' => '张飞', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '2', 'allsales' => 3250, 'name' => '程强', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '3', 'allsales' => 3100, 'name' => '张涛', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '4', 'allsales' => 2950, 'name' => '李斯', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '5', 'allsales' => 2750, 'name' => '程康', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '6', 'allsales' => 2500, 'name' => '夏正理', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '7', 'allsales' => 1900, 'name' => '汪洋', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '8', 'allsales' => 1650, 'name' => '邱勇', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '9', 'allsales' => 1300, 'name' => '余家攀', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '10', 'allsales' => 500, 'name' => '刘泰', 'name2' => '张飞', 'name3' => '张飞'],
            ];
        } elseif ($time == 'month') {
            $rows = [
                ['userid' => '1', 'allsales' => 13500, 'name' => '张飞', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '2', 'allsales' => 8350, 'name' => '程强', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '3', 'allsales' => 8300, 'name' => '张涛', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '4', 'allsales' => 8050, 'name' => '李斯', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '5', 'allsales' => 7750, 'name' => '程康', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '6', 'allsales' => 6500, 'name' => '夏正理', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '7', 'allsales' => 5900, 'name' => '汪洋', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '8', 'allsales' => 4650, 'name' => '邱勇', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '9', 'allsales' => 3300, 'name' => '余家攀', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '10', 'allsales' => 2500, 'name' => '刘泰', 'name2' => '张飞', 'name3' => '张飞'],
            ];
        } else {
            $rows = [
                ['userid' => '1', 'allsales' => 13500, 'name' => '张飞', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '2', 'allsales' => 9250, 'name' => '程强', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '3', 'allsales' => 8300, 'name' => '张涛', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '4', 'allsales' => 8050, 'name' => '李斯', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '5', 'allsales' => 7750, 'name' => '程康', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '6', 'allsales' => 6500, 'name' => '夏正理', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '7', 'allsales' => 5900, 'name' => '汪洋', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '8', 'allsales' => 4650, 'name' => '邱勇', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '9', 'allsales' => 3300, 'name' => '余家攀', 'name2' => '张飞', 'name3' => '张飞'],
                ['userid' => '10', 'allsales' => 2500, 'name' => '刘泰', 'name2' => '张飞', 'name3' => '张飞'],
            ];
        }
        return $rows;

        //获取一级粉丝userid
        $sql  = " SELECT userid FROM " . DB_B2B . ".relationship WHERE parentuserid = $userid ";
        $rows = $this->db->getRows($sql);

        $one_ary = array(); //一级粉丝userid
        if ($rows) {
            foreach ($rows as $value) {
                array_push($one_ary, (int) $value['userid']);
            }
        }

        if (!empty($one_ary)) {
            $userid_in = '';
            foreach ($one_ary as $value) {
                $userid_in .= $value . ',';
            }
            $userid_in = '(' . rtrim($userid_in, ',') . ')';

            $where   = '';
            $endline = time();
            if ($time == "week") {
                $beginline = $endline - 86400 * 7;
                $where     = " AND yw.dateline > $beginline AND yw.dateline < $endline ";
            } elseif ($time == "month") {
                $beginline = $endline - 86400 * 30;
                $where     = " AND yw.dateline > $beginline AND yw.dateline < $endline ";
            }

            $sql = " SELECT yw.userid,SUM(yw.price) AS allsales,
            y.username AS name1,y.name AS name2,u.username AS name3
            FROM " . DB_ORDERS . ".yun_wallet AS yw
            LEFT JOIN " . DB_ORDERS . ".yun_users AS y ON y.userid = yw.userid
            LEFT JOIN " . DB_MEMBERS . ".users AS u ON yw.userid = u.userid
            WHERE yw.type = 5 $where
            AND yw.userid IN $userid_in
            GROUP BY yw.userid
            ORDER BY allsales DESC
            LIMIT 0,10";
            // echo $sql;exit;
            $rows = $this->db->getRows($sql);
            foreach ($rows as $key => $value) {
                $rows[$key]['name'] = $value['name1'] ? $value['name1'] : ($value['name2'] ? $value['name2'] : $value['name3']);
            }
            return $rows;
        } else {
            return false;
        }
    }

    /**
     * 获取用户手机号，姓名
     * @return [type] [description]
     */
    public function getuser($str = "")
    {
        parse_str($str);

        $userid = (int) $userid;

        $query = " SELECT y.agencylevel,y.username AS name1,y.name AS name2,u.username AS name3,b.mobile,b.userid
        FROM " . DB_MEMBERS . ".bind_mobile AS b
        LEFT JOIN " . DB_ORDERS . ".yun_users AS y ON b.userid = y.userid
        LEFT JOIN " . DB_MEMBERS . ".users AS u ON u.userid = b.userid
        WHERE b.userid = $userid ";
        $info         = $this->db->getRow($query);
        $info['name'] = $info['name1'] ? $info['name1'] : ($info['name2'] ? $info['name2'] : $info['name3']);

        return $info;
    }

    /**
     * 获取会员信息
     * @return [type]      [description]
     */
    public function get_customs($str = "")
    {
        $str = plugin::extstr($str); //处理字符串
        extract($str);
        if ($userid) {$where .= " AND userid = " . (int) $userid . " ";}
        if ($customsid) {$where .= " AND customsid = " . (int) $customsid . " ";}
        $sql  = "SELECT * FROM " . DB_ORDERS . ".customs_users WHERE 1=1 $where ORDER BY customsid DESC ";
        $data = $this->db->getRow($sql);
        return $data;
    }

    /**
     * 录入会员信息
     * @return [type]      [description]
     */
    public function insert_customs($str = "")
    {
        extract($_POST);

        $arr = array(
            'name'       => $_POST["name"],
            'provid'     => $_POST["provid"],
            'cityid'     => $_POST["cityid"],
            'areaid'     => $_POST["areaid"],
            'address'    => $_POST["address"],
            'mobile'     => $_POST["mobile"],
            'dateline'   => time(),
            'updateline' => time(),
        );
        $this->db->insert(DB_ORDERS . ".customs", $arr);

        return 1;
    }

}
