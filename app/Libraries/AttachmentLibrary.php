<?php 

namespace App\Libraries;

class AttachmentLibrary {

    // Create a aws s3 client method 
    public function createS3Client() {

        // Create an S3 client
        $s3 = new \Aws\S3\S3Client([
            'version' => 'latest',
           'region'  => 'us-east-1',
            'credentials' => [
                'key'    => env('aws.client_id'),
               'secret' => env('aws.secret_key'),
            ]
        ]);

        return $s3;
    }

    function getBucketContents(){
        // Instantiate the S3 client
        $s3Client = $this->createS3Client();
    
        try {
            $contents = $s3Client->listObjectsV2([
                'Bucket' => env('aws.default_bucket_name'),
            ]);
            return $contents['Contents'];
        } catch (\Exception $exception) {
            echo "Failed to list objects in ".env('aws.default_bucket_name')." with error: " . $exception->getMessage();
            exit("Please fix error with listing objects before continuing.");
        }
    }

    // Upload a file to the s3 bucket
    public function uploadFileToS3($fileName) {
        $s3Client = $this->createS3Client();

        try {
            $result = $s3Client->putObject([
                'Bucket' => env('aws.default_bucket_name'),
                'Key' => "uploads/$fileName",
                'SourceFile' => WRITEPATH .'uploads/'. $fileName,
            ]);
            unlink(WRITEPATH.'uploads/'.$fileName);
            return $result;
        } catch (\Exception $exception) {
            echo "Failed to upload ".basename($fileName)." to ".env('aws.default_bucket_name')." with error: ". $exception->getMessage();
            exit("Please fix error with uploading file before continuing.");
        }
    }

    public function createPresignedUrl($fileName)
    {
        // Retrieve S3 client from the Aws service
        $s3Client = $this->createS3Client();
        // Specify the bucket and object (file) key
        $bucketName = env('aws.default_bucket_name'); 
        $fileKey = "uploads/$fileName";  // Change this to the actual file path in your S3 bucket
        // Define the expiration time of the URL (e.g., 1 hour)
        $expiration = '+20 minutes';  // URL will be valid for 1 hour
        // Generate the pre-signed URL
        try {
            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => $bucketName,
                'Key'    => $fileKey
            ]);

            $request = $s3Client->createPresignedRequest($cmd, $expiration);
            $presignedUrl = (string) $request->getUri();

            // Return or use the pre-signed URL
            return $presignedUrl;
        } catch (\Exception $e) {
            return response()->setJSON(['error' => $e->getMessage()]);
        }
    }
}