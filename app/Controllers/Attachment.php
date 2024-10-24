<?php

namespace App\Controllers;

use App\Controllers\BaseController;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Attachment extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function getIndex()
    {
        $db = \Config\Database::connect();

        $files = $db->table('attachments')->get()->getResultArray();

        // Pass the files to the view 
        $data = ['files' => $files];

        // $attachmentLibrary = new \App\Libraries\AttachmentLibrary();
        // $contents = $attachmentLibrary->getBucketContents();

        // log_message('error', json_encode($contents));

        return view('list_files',  $data);
    }

    public function postUpload_file(){
        // Upload a file to upload folder 
        $file = $this->request->getFile('file');
        if ($file->isValid()) {
            $newName = md5(uniqid()).'.'.$file->getClientExtension();
            $file->move(WRITEPATH.'uploads', $newName);

            $attachmentLibrary = new \App\Libraries\AttachmentLibrary();
            $attachmentLibrary->uploadFileToS3($newName);

            // Get file size 
            $size = $file->getSize();

            // Get a db connection  
            $db = \Config\Database::connect();

            // Insert file details into the database
            $data = [
                'file_name' => $newName,
                'file_size' => $size,
                'upload_path' => 'uploads/'
            ];
            $db->table('attachments')->insert($data);

            // Get all files uploaded
            $files = $db->table('attachments')->get()->getResultArray();

            // Pass the files to the view 
            $data = ['files' => $files];

            //Unlink files uploaded
            // unlink(WRITEPATH.'uploads/'.$newName);

            return redirect()->to('/')->with('message', ['File uploaded successfully']);
        } else {
            // return $this->response->setJSON(['message' => $file->getErrorString()], 400);
            return redirect()->to('/')->with('message', [$file->getErrorString()]);
        }
    }
}
