<?php

class CreatorController extends AppController {

	public $uses = false;

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function reload() {
		$action = $this -> request -> query('action');
		$id = $this -> request -> query('id');

		if ($this -> request -> is('ajax')) {
			if (empty($id)) {
				$this -> _error['error'] = 1;
				$this -> _error['message'] = "Invalid ID";
				exit(json_encode($this -> _error));
			}

			$this -> loadModel('Template');
			$template = $this -> Template -> find('first', array("conditions" => array("guid" => $id)));

			if (empty($template)) {
				$this -> _error['error'] = 1;
				exit(json_encode($this -> _error));
			}

			$template = $template['Template'];
			if (empty($template['content_json'])) {
				exit("nodata");
			}

			$this -> layout = false;
			if (!empty ($template['content_json'])) {
				$json = unserialize($template['content_json']);
			}
			exit(json_encode($json));
		}

		$this -> layout = false;
		$this -> _error['error'] = 1;
		exit(json_encode($this -> _error));
	}

	public function create() {

		$action = $this -> request -> query('action');
		$id = $this -> request -> query('id');

		if ($this -> request -> is('ajax') && $this -> request -> is('post')) {
			$this -> _save();
		}

		if (empty($id)) {

		}

		$this -> loadModel('Template');

		$template = $this -> Template -> find('first', array("conditions" => array("guid" => $id)));

		if (empty($template)) {
			$this->redirect (array ("controller" => "index", "action" => "index"));
		}

		$this -> layout = "creator";
		$this -> set('template', $template['Template']);
		$this -> set('action', $action);
	}

	protected function _save() {

		set_time_limit(0);
		$action = $this -> request -> query('action');
		$id = $this -> request -> query('id');

		if ($this -> request -> is('ajax') && $this -> request -> is('post')) {
			$this -> layout = false;

			if (empty($id)) {
				$this -> _error['error'] = 1;
				$this -> _error['message'] = "Invalid ID";
				exit(json_encode($this -> _error));
			}

			$this -> loadModel('Template');
			$template = $this -> Template -> find('first', array("conditions" => array("guid" => $id)));

			if (empty($template)) {
				$this -> _error['error'] = 1;
				$this -> _error['message'] = "Invalid ID";
				exit(json_encode($this -> _error));
			}

			$template = $template['Template'];

			$svg = $_POST['svg'];
			$json = $_POST['json'];
			$images = $_POST['image'];
			
			unset ($template['id']);
			$data = $template;
			
			$path = "file://" . WWW_ROOT . "uploads";
			
			$svg = str_replace ("http://inspireprint.com" . $this->webroot . "uploads", $path, $svg);
			//print_r ($svg);
			//exit;
			
			//$svg = str_replace ("http://inspireprint.com", )
			$data['content_json'] = serialize($json);
			$data['content_svg'] = $svg;
			$data['guid'] = uniqid();
			
			
			$images = $this -> _toImage($images, "jpeg", $data['guid']);

			foreach ($images as $image) {
				$image = WWW_ROOT . $this -> _media_location['template'] . $image;
				$ret = $this -> _resizeImage($image, $template['width'], $template['height']);
			}

			if (!$ret) {
				exit(json_encode($this -> _error));
			}

			$thumbnails = array();
			$featured = array();

			foreach ($images as $image) {
				$thumbnails[] = str_replace(".jpeg", "_small.png", $image);
				$featured[] = str_replace(".jpeg", "_medium.png", $image);
			}
			
			$svg = json_decode($svg);
			$filename = pathinfo ($image, PATHINFO_FILENAME);
			$filename = preg_replace ("/\_[0-9]{1,}/i", "", $filename);
			
			$data['output'] = array ();
			
			if (!empty ($svg)) {
				foreach ($svg as $key => $value) {
					file_put_contents (WWW_ROOT . $this->_media_location['template'] . $filename . "_$key.svg", $value);
					
				}
				
				$count = count ($svg);
				$svg = null;
				$key = 0;
				$value = null;
				
				for ($key = 0; $key < $count; $key++) {
					if (file_exists(WWW_ROOT . $this->_media_location['template'] . $filename . "_$key.svg")) {
						$this->_toPDF(WWW_ROOT . $this->_media_location['template'] . $filename . "_$key.svg", $template['width'], $template['height']);
						$data['output'][] = $filename . "_$key.pdf";	
					}
				}
			}
			
			// generate PDF, will be very slow here, even in a good server
			// don't know why
			
			if (!empty ($data['output'])) {
				$data['output'] = serialize($data['output']);
			} else {
				$data['output'] = "";
			}
			
			$data['featured'] = serialize($featured);
			$data['thumbnails'] = serialize($thumbnails);
			$data['status'] = 'publish';
			$data['type'] = 'template_from_user';
			$data['parent_guid'] = $template['guid'];
			$data['created'] = time();
			$data['modified'] = time();

			$this -> Template -> create();
			$this -> Template -> save($data);
			$this -> _error['error'] = 0;

			exit(json_encode($this -> _error));
		}
	}

	public function _toImage($images, $extension, $basename) {
		if ($this -> request -> is('ajax')) {
			$this -> layout = false;

			error_reporting(0);
			register_shutdown_function(function() {

				$last_error = error_get_last();

				if (!is_null($last_error)) {
					$this -> _error['error'] = 1;
					$this -> _error['message'] = $last_error['message'];
					exit(json_encode($this -> _error));
				}
			});

			//            $image = new Imagick();
			//            $image->readImageBlob($imageData);
			//            $image->setImageFormat("png32");
			//            $image->resizeImage($width, $height, imagick::FILTER_LANCZOS, 1);
			//            $image->writeImage(WWW_ROOT . $this->_media_location['main'] . "svg.png");
			//
			//            return;

			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			$targetDir = WWW_ROOT . $this -> _media_location['template'];

			$cleanupTargetDir = true;
			// Remove old files
			$maxFileAge = 5 * 3600;
			// Temp file age in seconds
			@set_time_limit(0);

			$result = array();

			foreach ($images as $key => $imageData) {

				$imageData = str_replace("data:image/" . $extension . ";base64,", "", $imageData);

				$filename = $basename . "_" . $key . "." . $extension;
				$file = base64_encode($imageData);
				$out = @fopen($targetDir . DIRECTORY_SEPARATOR . $filename, "wb");

				if ($out) {
					fwrite($out, base64_decode($imageData));
					@fclose($out);
				} else {
					$this -> _error['error'] = 1;
					$this -> _error['message'] = 'open write handler faild';
					exit(json_encode($this -> _error));
				}

				$result[$key] = $filename;
			}

			return $result;
		}
	}

	protected function _resizeImage($target, $width, $height) {

		require_once APP . 'Vendor' . DIRECTORY_SEPARATOR . "Zebra/Zebra_Image.php";
		$image = new Zebra_Image();

		$image -> source_path = $target;

		$image -> jpeg_quality = 100;

		$image -> preserve_aspect_ratio = true;
		$image -> enlarge_smaller_images = true;
		$image -> preserve_time = true;

		$filename = pathinfo($target, PATHINFO_FILENAME);
		$image -> target_path = WWW_ROOT . $this -> _media_location['template'] . $filename . "_medium.png";

		if (!$image -> resize($width * 2, $height * 2, ZEBRA_IMAGE_BOXED, -1)) {
			$this -> _error['error'] = 1;
			$this -> _error['message'] = "Resize to $width x2 wrong";
			return false;
		}

		$image -> target_path = WWW_ROOT . $this -> _media_location['template'] . $filename . "_small.png";

		$width = $width;
		$height = $height;

		if (!$image -> resize($width, $height, ZEBRA_IMAGE_BOXED, -1)) {
			$this -> _error['error'] = 1;
			$this -> _error['message'] = "Resize to $width wrong";
			return false;
		}

		return true;
	}

	protected function _toPDF($target, $width, $height) {
		// always load alternative config file for examples
		require_once (APP . 'Vendor' . DIRECTORY_SEPARATOR . 'tcpdf/examples/config/tcpdf_config_alt.php');
		require_once (APP . 'Vendor' . DIRECTORY_SEPARATOR . 'tcpdf/tcpdf.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		//$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		//$pdf->SetTitle('TCPDF Example 058');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 058', PDF_HEADER_STRING);
		
		// set header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf-> setFontSubsetting(false);
		
		// set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetHeaderMargin(0);//PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(0);//PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAutoPageBreak(false, 0);
		
		// set image scale factor
		$pdf->setImageScale(1);//PDF_IMAGE_SCALE_RATIO);
		
		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			//require_once(dirname(__FILE__).'/lang/eng.php');
			//$pdf->setLanguageArray($l);
		}
		
		// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('helvetica', '', 10);
		
		// set page format (read source code documentation for further information)
		$page_format = array(
		    'MediaBox' => array ('llx' => 0, 'lly' => 0, 'urx' => $width, 'ury' => $height),
		    //'CropBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 210, 'ury' => 297),
		    //'BleedBox' => array ('llx' => 5, 'lly' => 5, 'urx' => 205, 'ury' => 292),
		    //'TrimBox' => array ('llx' => 10, 'lly' => 10, 'urx' => 200, 'ury' => 287),
		    //'ArtBox' => array ('llx' => 15, 'lly' => 15, 'urx' => 195, 'ury' => 282),
		    'Dur' => 3,
		    'trans' => array(
		        'D' => 1.5,
		        'S' => 'Split',
		        'Dm' => 'V',
		        'M' => 'O'
		    ),
		    'Rotate' => 0,
		    'PZ' => 1,
		);
		
		// Check the example n. 29 for viewer preferences
		
		// add first page ---
		$pdf->AddPage('P', $page_format, false, false);
		
		// NOTE: Uncomment the following line to rasterize SVG image using the ImageMagick library.
		//$pdf->setRasterizeVectorImages(true);
		
		$pdf->ImageSVG($target, $x=0, $y=0, $w="$width", $h="$height", $link='', $align='', $palign='', $border=0, $fitonpage=true);
		
		//Close and output PDF document
		$file = str_replace (".svg", ".pdf", $target);
		$pdf->Output($file , 'F');
		//$pdf->Output('example_058.pdf', 'D');
	}

	// based on pluploader library

	public function upload() {

		error_reporting(0);
		register_shutdown_function(function() {

			$last_error = error_get_last();

			if (!is_null($last_error)) {
				$this -> _error['error'] = 1;
				$this -> _error['message'] = $last_error['message'];
				exit(json_encode($this -> _error));
			}
		});

		$this -> autoRender = false;
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$targetDir = $this -> _targetDir = WWW_ROOT . 'uploads';

		$cleanupTargetDir = true;
		// Remove old files
		$maxFileAge = 5 * 3600;
		// Temp file age in seconds
		@set_time_limit(0);

		/*
		 chunk_size
		 Enables you to chunk the file into smaller pieces for example if your PHP backend has a max post size of 1MB you can chunk a 10MB file into 10 requests. To disable chunking, remove this config option from your setup.
		 *
		 * It's a smart idea, commonly PHP will have this limitation/upload
		 * As I know, 128MB is maximium value of some web share host
		 *
		 * chunk : the index of part of the file
		 * chunks : total parts of the file
		 */
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

		if (!file_exists($targetDir))
			@mkdir($targetDir);

		if ($cleanupTargetDir) {
			if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
				while (($file = readdir($dir)) !== false) {
					$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

					// Remove temp file if it is older than the max age and is not the current file
					if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
						@unlink($tmpfilePath);
					}
				}
				closedir($dir);
			} else {
				$this -> _error['error'] = 1;
				$this -> _error['message'] = 'Failed to open temp directory.';
				die($this -> _json($this -> _error));
			}
		}

		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];

		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = @fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else {
						$this -> _error['error'] = 1;
						$this -> _error['message'] = 'Failed to open input stream.';
						die($this -> _json($this -> _error));
					}

					@fclose($in);
					@fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else {
					$this -> _error['error'] = 1;
					$this -> _error['message'] = 'Failed to open output stream.';
					die($this -> _json($this -> _error));
				}
			} else {
				$this -> _error['error'] = 1;
				$this -> _error['message'] = 'Failed to move uploaded file.';
				die($this -> _json($this -> _error));
			}
		} else {
			// Open temp file
			$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = @fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else {
					$this -> _error['error'] = 1;
					$this -> _error['message'] = 'Failed to open input stream.';
					die($this -> _json($this -> _error));
				}

				@fclose($in);
				@fclose($out);
			} else {
				$this -> _error['error'] = 1;
				$this -> _error['message'] = 'Failed to open output stream.';
				die($this -> _json($this -> _error));
			}
		}

		$name = pathinfo($fileName, PATHINFO_FILENAME);
		$extension = pathinfo($fileName, PATHINFO_EXTENSION);

		$original = $name . "." . $extension;
		$name .= "_" . time() . "." . $extension;

		$target = $targetDir . DIRECTORY_SEPARATOR . $name;

		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename("{$filePath}.part", $target);
		}

		//$finfo = finfo_open(FILEINFO_MIME_TYPE);
		// $mime = finfo_file($finfo, $target);
		//finfo_close($finfo);

		$this -> _error['error'] = 0;
		$this -> _error['message'] = '';

		$this -> _error['files'] = array('original' => $original, 'target' => $name, 'url' => $this -> base . "/uploads/" . $name, 'extension' => $extension,
		//'mime' => $mime
		);

		die($this -> _json($this -> _error));
	}

	protected function _json($data = array()) {
		return json_encode($data);
		//, JSON_UNESCAPED_SLASHES);
	}

}
