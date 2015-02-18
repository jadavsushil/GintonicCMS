<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;
use Cake\Network\Session;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

class FilesTable extends Table 
{   
    public function initialize(array $config)
    {
        $this->belongsTo('Users', [
            'className' => 'Users',
//            'foreignKey' => 'user_id',
//            'propertyName' => 'Sender',
        ]);
    }
    
//    public function save(\Cake\Datasource\EntityInterface $entity, $options = array()) {
//        //$this->set($entity);
//        if($entity->modified){
//            unset($entity->modified);
//        }
//        parent::save($entity, $options);
//    }
    

    public function moveUploaded($tmpFile, $userId, $dirName, $count) {
        // fetch data
        $fileInfo['user_id'] = $userId;
        $fileInfo['size'] = $tmpFile['tmpFile']['size'];
        $fileInfo['type'] = $tmpFile['tmpFile']['type'];
        $fileInfo['title'] = $tmpFile['title'];
        $fileInfo['ext'] = pathinfo($tmpFile['tmpFile']['name'], PATHINFO_EXTENSION);
        $fileInfo['filename'] = $this->createFileName($fileInfo['ext'], $userId, $count);

        // move file
        $file = fopen($tmpFile['tmpFile']['tmp_name'], "rb");
        $data = fread($file, $fileInfo['size']);
        file_put_contents($this->getPath($fileInfo['filename'], $dirName), $data);

        return $fileInfo;
    }

    // This function creates/define what path and filename to give before storing it
    public function createFileName($ext, $userId, $count) {
        $count = empty($count) ? '' : ('_' . $count);
        return date("d_m_Y_G.i.s") . '_' . $userId . $count . '.' . $ext;
    }
    
    function save(\Cake\Datasource\EntityInterface $entity, $options = array()) {
        if(!isset($entity->created)){
            $entity->created = date('Y-m-d H:i:s');
        }
        parent::save($entity, $options);
    }

    public function getPath($filename, $dirName) {
        if (empty($dirName)) {
            $path = WWW_ROOT . 'files' . DS . 'uploads' . DS;
        } else {
            $path = WWW_ROOT . 'files' . DS . 'uploads' . DS . $dirName . DS;
        }
        //Check folder and if not exist then create folder
        $dir = new Folder($path, true, 0777);
        return $path . $filename;
    }

    public function getUrl($filename) {
        return 'files/uploads/' . $filename;
    }

    public function deleteFile($filename) {
        $file = new File($this->getPath($filename));
        $file->delete();
    }

}
