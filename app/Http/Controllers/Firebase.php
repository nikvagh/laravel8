<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class Firebase extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function snapshot(){
        $reference = $this->database->getReference('dsfds');
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();
        echo "<pre>";
        print_r($value);
        exit;
    }

    public function save(){
        $this->database->getReference('config1/website')->set([
            'name' => 'My Application',
            'emails' => [
                'support' => 'support@domain.tld',
                'sales' => 'sales@domain.tld',
            ],
            'website' => 'https://app.domain.tld',
            ]);

        if($this->database->getReference('config1/website/name')->set('New name')){
            echo "data saved";
        }
    }

    public function update_specific_field(){
        $uid = 'some-user-id';
        $postData = [
            'title' => 'My awesome post title',
            'body' => 'This text should be longer',
        ];

        // Create a key for a new post
        $newPostKey = $this->database->getReference('posts')->push()->getKey();

        $updates = [
            'posts/'.$newPostKey => $postData,
            'user-posts/'.$uid.'/'.$newPostKey => $postData,
        ];

        if($this->database->getReference()->update($updates)){
            echo "data updated";
        }
    }
}
