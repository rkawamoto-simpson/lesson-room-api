<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class TeachingMaterialCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+60 minutes";
        foreach($this->collection as $key=>$value){
            if(empty($this->collection[$key]['teaching_materials']) || $this->collection[$key]['teaching_materials'] == NULL){
                continue;
            }
            $command = $client->getCommand('GetObject', [
                'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                'Key'    => $this->collection[$key]['teaching_materials']
            ]);
            $request = $client->createPresignedRequest($command, $expiry);
            $this->collection[$key]['teaching_materials'] = (string) $request->getUri();
        }
       
        return $this->collection;
    }
}
