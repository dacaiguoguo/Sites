<?php

// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Common\Aws;

// Instantiate the S3 client using your credential profile
$s3Client = S3Client::factory(array(
    'profile' => 'credentials.csv',
	'region'  => 'us-west-2'
));


// Create a service builder using a configuration file
$aws = Aws::factory(array(
    'profile' => 'credentials.csv',
	'region'  => 'us-west-2'
));
// Get the client from the builder by namespace
$client = $aws->get('S3');

if (!$client) {
	echo 'error';
} else {
	echo 'success client';
	try {
		echo 'try';
		$result = $client->createBucket(array('Bucket' => 'myxiaocaibucket'));
		echo $result['Location'] . "\n";
	} catch (\Aws\S3\Exception\S3Exception $e) {
		echo 'try error';
	    echo $e->getMessage();
	}
}

// try {
// 	echo 'try';
//     $s3Client->createBucket(array(
//         'Bucket' => 'xiaocaiguo-bucket'
//     ));
// } catch (\Aws\S3\Exception\S3Exception $e) {
//     // The bucket couldn't be created
// 	echo 'try error';
//     echo $e->getMessage();
// }
// s3Client.downloadBucket("./","dacaiguoguobucket","user.json",NULL);

?>