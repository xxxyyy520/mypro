<?php
require_once __DIR__.'/autoload.php';
//require_once __DIR__ . './samples/Common.php';
use OSS\OssClient;
use OSS\Core\OssException;

class Alioss{
  public $accessKeyId = 'sz0M0VDTQfEiSpGU';
  public $accessKeySecret = 'PrCpJ7hmjDsdv8cSMUhNli6tBdqS1U';
  public $endpoint = ALIOSS_URL;
  // 外网 oss-cn-beijing.aliyuncs.com 内网 oss-cn-beijing-internal.aliyuncs.com
  public $bucket= "shuifile"; //  http://upfile.yos.shui.cn/wes/xxxxx.jpg
  //列举文件
  public function getlists(){
    try {
        $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        $listObjectInfo = $ossClient->listObjects($this->bucket);
        $objectList = $listObjectInfo->getObjectList();
        if (!empty($objectList)) {
            foreach ($objectList as $objectInfo) {
            print($objectInfo->getKey() . "\t" . $objectInfo->getSize() . "\t" . $objectInfo->getLastModified() . "\n");
            }
        }
    } catch (OssException $e) {
        print $e->getMessage();
    }
  }

/*********************下载文件**********************/
  //下载文件
  /**
 * get_object_to_local_file
 *
 * 获取object
 * 将object下载到指定的文件
 *
 * @param OssClient $ossClient OSSClient实例
 * @param string $bucket 存储空间名称
 * @return null
 */
  public function getObjectToLocalFile(){
    $object = "";//要下载图片位置  123.jpg
      $localfile = "";//下载文件存放位置 src/example.jpg
      $options = array(
          OssClient::OSS_FILE_DOWNLOAD => $localfile,
      );
      try{
          $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
          $ossClient->getObject($this->bucket, $object, $options);
      } catch(OssException $e) {
          printf(__FUNCTION__ . ": FAILED\n");
          printf($e->getMessage() . "\n");
          return;
      }
      print(__FUNCTION__ . ": OK, please check localfile: 'example.jpg'" . "\n");
    }
    /**
 * 获取object的内容
 *
 * @param OssClient $ossClient OSSClient实例
 * @param string $bucket 存储空间名称
 * @return null
 *如果OSS文件较大，您只需要其中一部分数据，可以使用范围下载，下载指定范围的数据。
 *如果指定的下载范围是0 - 100，则返回第0到第100个字节的数据，
 *包括第100个，共101字节的数据，即[0, 100]。如果指定的范围无效，则下载整个文件。
 */
    function getObject()
    {
        $object = "";//c.txt
        try{
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            $options = array(OssClient::OSS_RANGE => '0-100');
            $content = $ossClient->getObject($this->bucket, $object, $options);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        print(__FUNCTION__ . ": OK" . "\n");
    }

    /*********************上传图片**********************/
    /**
 * 上传指定的本地文件内容
 *
 * @param OssClient $ossClient OSSClient实例
 * @param string $bucket 存储空间名称
 * @return null
 */
    public function uploadFile($files,$object=""){
        if($object==""){
            $object ="upfile/".date("Y")."/".date("m")."-".date("d")."/".$files;//print_r($object);//要上传图片位置
        }
        //$object ="wes/".date("Y")."/".date("m")."-".date("d")."/".$files;//print_r($object);//要上传图片位置
        $filePath = $files;
        //$filePath = $R_ROOT.'data/'.$files;//print_r($filePath);exit;//本地上传图片位置
        try{
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            $ossClient->setTimeout(3600 /* seconds */);
            $ossClient->setConnectTimeout(10 /* seconds */);
            $ossClient->uploadFile($this->bucket, $object, $filePath);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        //print(__FUNCTION__ . ": OK" . "\n");
    }

        //分片上传本地文件
      public function multiuploadFile()
      {
          $object = "";//要上传图片位置
          $file = __FILE__;//本地上传图片位置
          try{
              $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
              $ossClient->multiuploadFile($this->bucket, $object, $file);
          } catch(OssException $e) {
              printf(__FUNCTION__ . ": FAILED\n");
              printf($e->getMessage() . "\n");
              return;
          }
          print(__FUNCTION__ . ":  OK" . "\n");
      }


    //分片上传本地目录里的文件
    /**
     * 按照目录上传文件
     *
     * @param OssClient $ossClient OssClient
     * @param string $bucket 存储空间名称
     *
     */
    public function uploadDir(){

      $localDirectory = "";//文件目录没做
          $prefix = "";
          try {
              $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
              $ossClient->uploadDir($this->bucket, $prefix, $localDirectory);
          }  catch(OssException $e) {
              printf(__FUNCTION__ . ": FAILED\n");
              printf($e->getMessage() . "\n");
              return;
          }
          printf(__FUNCTION__ . ": completeMultipartUpload OK\n");
    }



    //删除单个文件
    /**
     * 删除object
     *
     * @param OssClient $ossClient OSSClient实例
     * @param string $bucket bucket名字
     * @return null
     */
    public function deleteObject($files){
    $object = $files;//oss上文件位置
        try{
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            $ossClient->deleteObject($this->bucket, $object);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        // print(__FUNCTION__ . ": OK" . "\n");

  }

      /**
       * 批量删除object
       *
       * @param OssClient $ossClient OSSClient实例
       * @param string $bucket bucket名字
       * @return null
       */
    function deleteObjects()
    {
        $objects = array();
        $objects[] = "";
        $objects[] = "";
        try{
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            $ossClient->deleteObjects($this->bucket, $objects);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        print(__FUNCTION__ . ": OK" . "\n");
    }


    //拷贝文件
    /**
     * 拷贝object
     *
     * @param OssClient $ossClient OSSClient实例
     * @param string $bucket bucket名字
     * @return null
     */
    public function copyObject(){
      $from_bucket = $this->bucket;
      $from_object = "";
      $to_bucket = $this->bucket;
      $to_object = $from_object . '.copy';
      try{
          $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
          $ossClient->copyObject($from_bucket, $from_object, $to_bucket, $to_object);
      } catch(OssException $e) {
          printf(__FUNCTION__ . ": FAILED\n");
          printf($e->getMessage() . "\n");
          return;
      }
      print(__FUNCTION__ . ": OK" . "\n");

    }
    //列出用户所有的存储空间
  public function listBuckets()
    {
      $bucketList = null;
      try{
          $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
          $bucketListInfo = $ossClient->listBuckets();
      } catch(OssException $e) {
          printf(__FUNCTION__ . ": FAILED\n");
          printf($e->getMessage() . "\n");
          return;
      }
      $bucketList = $bucketListInfo->getBucketList();
      foreach($bucketList as $bucket) {
          print($bucket->getLocation() . "\t" . $bucket->getName() . "\t" . $bucket->getCreatedate() . "\n");
      }
    }




}

//$alioss = new Alioss();
//$alioss->getlists();
//echo "<hr/>";
//$alioss->getObjectToLocalFile();
//$alioss->uploadFile();
//$alioss->uploadDir();
//$alioss->deleteObject();
//$alioss->deleteObjects();
//$alioss->listBuckets();
//$alioss->copyObject();
