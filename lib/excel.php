<?php
/**

http://code.google.com/p/php-excel/downloads/

require LIB.'excel.php';
$data = array(
		1 => array ('名称', '中国'),
		array('222', 'Oliver'),
		array('222', 'Peter')
);
$xls = new excel();
$xls = excel('UTF-8',false,'My Test Sheet'); //编码/未知/表段名称
$xls->addArray($data);
$xls->generateXML('my-test');//保存的文件名
 */
class excel
{

    private $header = "<?xml version=\"1.0\" encoding=\"%s\"?\>\n<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">";
    private $footer = "</Workbook>";
    private $lines = array();
	public  $convtype = false;
	public  $encode = "UTF-8";
	public  $title = "table1";

	/**
	* Set worksheet title
	* 
	* Strips out not allowed characters and trims the
	* title to a maximum length of 31.
	* 
	* @param string $title Title for worksheet
	*/
	public function setTitle($title)
	{
			$title = preg_replace ("/[\\\|:|\/|\?|\*|\[|\]]/", "", $title);
			$title = substr ($title, 0, 31);
			return $title;
	}

	/**
	 * Add row
	 * 
	 * Adds a single row to the document. If set to true, self::convtype
	 * checks the type of variable and returns the specific field settings
	 * for the cell.
	 * 
	 * @param array $array One-dimensional array with row content
	 */
	private function addRow ($array)
	{
		$cells = "";
			foreach ($array as $k => $v):
					$type = 'String';
					if ($this->convtype === true && is_numeric($v)):
							$type = 'Number';
					endif;
					$v = htmlentities($v, ENT_COMPAT,$this->encode);
					$cells .= "<Cell><Data ss:Type=\"$type\">" . $v . "</Data></Cell>\n"; 
			endforeach;
			$this->lines[] = "<Row>\n" . $cells . "</Row>\n";
	}

	/**
	 * Add an array to the document
	 * @param array 2-dimensional array
	 */
	public function addArray ($array)
	{
			foreach ($array as $k => $v)
					$this->addRow ($v);
	}


	/**
	 * Generate the excel file
	 * @param string $filename Name of excel file to generate (...xls)
	 */
	public function generateXML ($filename = 'excel-export')
	{
			// correct/validate filename
			$filename = preg_replace('/[^aA-zZ0-9\_\-]/', '', $filename);

			// deliver header (as recommended in php manual)
			header("Content-Type: application/vnd.ms-excel; charset=" . $this->encode);
			header("Content-Disposition: inline; filename=\"" . $filename . ".xls\"");

			// print out document to the browser
			// need to use stripslashes for the damn ">"
			echo stripslashes (sprintf($this->header, $this->encode));
			echo "\n<Worksheet ss:Name=\"".$this->setTitle($this->title). "\">\n<Table>\n";
			foreach ($this->lines as $line)
					echo $line;

			echo "</Table>\n</Worksheet>\n";
			echo $this->footer;
	}

}

?>