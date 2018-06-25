<?php
class articleModules extends Modules
{
    /**
     * 获取产品列表图片
     * @param  string $str [description]
     * @return [type]      [description]
     */
    public function gettopic($str = "")
    {
        parse_str($str);
        if ($parentid != '') {
            $parentid = (int) $parentid;
            $where .= " AND parentid = $parentid ";
        }

        if ($topic != '') {
            $topic = (int) $topic;
            $where .= " AND topic = $topic ";
        }

        $query = " SELECT topic,pic FROM " . DB_YIJIA . ".topic WHERE checked = 1 $where ";
        $info  = $this->db->getRows($query);

        return $info;
    }

    /**
     * 获取产品各个图片
     * @return [type] [description]
     */
    public function getarticle($str = "")
    {
        parse_str($str);
        $topicid = (int) $topicid;

        $query = " SELECT a.pic,a.articleid FROM " . DB_YIJIA . ".article AS a
        INNER JOIN " . DB_YIJIA . ".topicinfo AS t ON a.articleid = t.articleid
        WHERE a.checked = 1 AND t.topic = $topicid
        ORDER BY a.dateline DESC";
        $info = $this->db->getRows($query);
        // echo $query;
        return $info;
    }

    /**
     * 获取分享技巧文章
     * @return [type] [description]
     */
    public function getarticlelists($str = "")
    {
        parse_str($str);
        $topicid = (int) $topicid;

        $query = " SELECT a.articleid,a.pic,a.title,a.detail FROM " . DB_YIJIA . ".article AS a
        INNER JOIN " . DB_YIJIA . ".topicinfo AS t ON a.articleid = t.articleid
        WHERE a.checked = 1 AND t.topic = $topicid
        ORDER BY a.dateline DESC";
        $info = $this->db->getPageRows($query, 10);
        // echo $query;
        return $info;
    }

    /**
     * 通过articleid获取信息
     * @return [type] [description]
     */
    public function getarticleinfo($str = "")
    {
        parse_str($str);
        $articleid = (int) $articleid;

        $query = " SELECT a.title,a.articleid,a.pic,a.urlto,ai.content FROM " . DB_YIJIA . ".article AS a
        INNER JOIN " . DB_YIJIA . ".articleinfo AS ai ON a.articleid = ai.articleid
        WHERE a.checked = 1 AND a.articleid = $articleid ";
        $info = $this->db->getRow($query);
        // echo $query;
        return $info;
    }

}
