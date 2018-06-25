<?php
class articleAction extends Action
{
    /**
     * 技巧列表
     * @return [type] [description]
     */
    public function app()
    {
        $this->onlogin();

        $article = getModel("article");
        if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
            $topicid = '1386';
        } else {
            $topicid = '1387';
        }
        $rows = $article->getarticlelists("topicid=$topicid");
        // var_dump($rows['record']);
        $this->tpl->set("list", $rows['record']);
        $this->tpl->set("pages", $rows['pages']);
        $this->tpl->display('article.php');
    }

    /**
     * 招募
     * @return [type] [description]
     */
    public function recruit()
    {
        $article = getModel("article");

        if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
            $articleid = '4486';
        } else {
            $articleid = '4552';
        }
        $rows = $article->getarticleinfo("articleid=$articleid");
        // var_dump($rows);
        $this->tpl->set("rows", $rows);
        $this->tpl->display('article.views.php');
    }

    /**
     * 文章详情
     * @return [type] [description]
     */
    public function articledetail()
    {
        $this->onlogin();

        $article   = getModel("article");
        $articleid = base64_decode($_GET['articleid']);
        $rows      = $article->getarticleinfo("articleid=$articleid");
        // var_dump($rows);
        $this->tpl->set("rows", $rows);
        $this->tpl->display('article.views.php');
    }

}
