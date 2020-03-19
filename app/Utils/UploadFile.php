<?php

	namespace App\Utils;

	/**
	 * Permet de faire l'upload des fichiers
	 */
	class UploadFile
	{
		protected $file;
		protected $types = [
			'image' => ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF', 'webp', 'WEBP'],
			'video' => ['mp4', 'wmv', 'MP4', 'WMV'],
			'audio' => ['mp3', 'm4a', 'MP3', 'M4A'],
			'text'  => ['txt', 'TXT', 'pdf', 'PDF', 'doc', 'DOC', 'docx', 'DOCX']
		];
		protected $result = ['success' => false, 'data' => [], 'message' => null];

		public function __construct($file)
		{
			$this->file = $file;
		}

		/**
		 * Permet d'uploader un fichier
		 * @package ZUpload
		 */
		public function upload()
		{
			$type = explode('/', $this->file['type'])[0];
			$ext = explode('/', $this->file['type'])[1];
			$folder = 'public/medias/'.$type.'s';

			if (!empty($this->types[$type])) {
				if ($this->file['error'] == 0) {
	                
	                $file_info = pathinfo($this->file['name']);
	                $extension = $file_info['extension'];
	                $filename = 'uhtec-gsc-'.date('d-m-Y-h-i-s-t') . '.' . $extension;
	                $destination = $folder.'/'.$filename;

	                if (in_array($extension, $this->types[$type])) {
	                	$array_folder = explode('/', $folder);
	                	$i = 0;
	                	$fold = '';

	                	if (!file_exists($folder)) {
	                		while (!file_exists($folder)) {
		                		$fold .= $array_folder[$i].= '/';
		                		if (!file_exists($fold)) {
		                			mkdir($fold);
		                		}

		                		$i++;
		                	}
	                	}

                        move_uploaded_file($this->file['tmp_name'], $destination);

                        $this->result['success'] = true;
                        $this->result['message'] = 'Upload bien effectué';
                        $this->result['data']['size'] = $this->file['size'];
                        $this->result['data']['path'] = $destination;
                        $this->result['data']['type'] = $type;
                        $this->result['data']['filename'] = $filename;

                    }else{
                        $this->result['message'] = 'Extension non prise en charge, veuillez réessayer !';
                    }
	                
	            }else {
	                $this->result['message'] = 'Fichier invalide';
	            }
	        }else {
	        	$this->result['message'] = 'Type de fichier n\'est pas supporté';
	        }

	        return $this->result;
		}
	}