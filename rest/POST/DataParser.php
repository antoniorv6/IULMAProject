<?php 
	
	include('PdfToText/PdfToText.phpclass');
	class DataParser
	{
		private $path;

		public function __construct($filePath) 
    	{
        	$this->path = $filePath;
    	}

    	public function __destruct()
    	{

    	}

    	public function convertToText() 
    	{
	        if(isset($this->path) && !file_exists($this->path)) {
	            return "File Not exists";
	        }

	        $fileArray = pathinfo($this->path);
	        $file_ext  = $fileArray['extension'];
	        if($file_ext == "doc" || $file_ext == "docx" || $file_ext == "pdf")
	        {
	            if($file_ext == "doc") 
	            {
	                return $this->read_doc();
	            } 
	            elseif($file_ext == "docx") 
	            {
	                return $this->read_docx();
	            }
	            elseif($file_ext == "pdf")
	            {
	            	return $this->read_pdf();
	            }
	        } 
	        else 
	        {
	            return "Invalid File Type";
	        }
    	}

    	private function read_doc() 
    	{
	        $fileHandle = fopen($this->path, "r");
	        $line = @fread($fileHandle, filesize($this->path));   
	        $lines = explode(chr(0x0D),$line);
	        $outtext = "";
	        foreach($lines as $thisline)
	          {
	            $pos = strpos($thisline, chr(0x00));
	            if (($pos !== FALSE)||(strlen($thisline)==0))
	              {
	              } 
				  else {
	                $outtext .= $thisline." ";
	              }
	          }
	         $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
	        return $outtext;
    	}

    	private function read_docx()
    	{
	        $striped_content = '';
	        $content = '';

	        $zip = zip_open($this->path);

	        if (!$zip || is_numeric($zip)) return false;

	        while ($zip_entry = zip_read($zip)) {

	            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

	            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

	            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

	            zip_entry_close($zip_entry);
	        }// end while

	        zip_close($zip);

	        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
	        $content = str_replace('</w:r></w:p>', "\r\n", $content);
	        $striped_content = strip_tags($content);

	        return $striped_content;
    	}

    	private function read_pdf()
    	{
    		$pdf = new PdfToText($this->path);
    		$text = $pdf->Text;
    		return $text;
    	}

}


?>