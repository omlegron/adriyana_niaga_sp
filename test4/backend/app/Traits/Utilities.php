<?php
namespace App\Traits;
use App\Models\File;
use App\Models\Master\MasterTag;
use Validator;
use App\Helpers\HelperPhoto;
use App\Models\User;
trait Utilities
{

    public static function options($display, $id = 'id', $params = [], $default=null)
    {
        $q = static::select('*');

        $params = array_merge([
            'valuePrefix' => '',
        ], $params);

        if (isset($params['filters'])) {
            foreach ($params['filters'] as $key => $value) {
                if (is_numeric($key) && is_callable($value)) {
                    $q = $q->where($value);
                } else {
                    if($value != '')
                        $q = $q->where($key, $value);
                }
            }
        }

        if (isset($params['orders'])) {
            foreach ($params['orders'] as $key => $value) {
                if (is_numeric($key)) {
                    $key   = $value;
                    $value = 'asc';
                }

                $q = $q->orderBy($key, $value);
            }
        }

        $r = [];

        $ret = '';
        if ($default !== false) {
            if($default === null){
                $default = '(Pilih Salah Satu)';
            }
            $ret = '<option value="">' . $default . '</option>';
        }

        if (is_string($display)) {
            $q = $q->orderBy($display, 'asc');
            $r = $q->pluck($display, $id);

            foreach ($r as $i => $v) {
                $i = $params['valuePrefix'] . $i;
                $checked = isset($params['selected']) &&
                           (is_array($params['selected']) ? in_array($i, $params['selected']) : $i == $params['selected']);
                if ($checked) {
                    $ret .= '<option value="' . $i . '" selected>' . $v . '</option>';
                } else {
                    $ret .= '<option value="' . $i . '">' . $v . '</option>';
                }
            }
        } elseif (is_callable($display)) {
            $r = $q->get();

            foreach ($r as $d) {
                $i = $params['valuePrefix'] . $d->$id;
                $checked = isset($params['selected']) &&
                           (is_array($params['selected']) ? in_array($i, $params['selected']) : $i == $params['selected']);
                if ($checked) {
                    $ret .= '<option value="' . $i . '" selected>' . $display($d) . '</option>';
                } else {
                    $ret .= '<option value="' . $i . '">' . $display($d) . '</option>';
                }
            }
        }
        return $ret;
    }

    
    public static function queryRaw($query)
    {
        $q = static::select('*');

        $q->from(\DB::raw("($query) as tbl"));

        return $q->get();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function creatorName()
    {
        return isset($this->creator) ? $this->creator->username : '[System]';
    }

    public function creatorRole()
    {
        $role = '-';
        if($this->creator){
            if($this->creator->roles){
                $role = ($this->creator->roles->first()) ? $this->creator->roles->first()->name : '-';
            }
        }
        return $role;
    }

    public function creatorAndRole()
    {
        $return = $this->creatorName().'<br> ('.$this->creatorRole().')';
        return $return;
    }

    public function creationDate()
    {
        if($this->updated_at)
        {
          return $this->updated_at->locale('in')->diffForHumans();
        }
        return ($this->created_at) ? $this->created_at->locale('in')->diffForHumans() : '-';
    }

    public function dateCreator()
    {
        if($this->updated_at)
        {
          return createdAt($this->updated_at);
        }
        return ($this->created_at) ? createdAt($this->created_at) : '-';
    }


    /* SAVE DATA */
    public static function saveData($request, $identifier = 'id')
    {
        $record = static::prepare($request, $identifier);
        if(@$record->rules){
            $validateData = $request->validate($record->rules);
        }
        $isFile = isset($request['file']) ? $request['file'] : [];
        $record->fill($request->all());
        $record->save();

        if($isFile)
        {
            $typeFiles = 'Lampiran 1';
            if($request['typeFiles']){
                $typeFiles = $request['typeFiles'];
            }
            $record->uploadFile($isFile, $typeFiles);
        }

        if($request->fileIdDel){
            $record->deleteFile($request->fileIdDel);
        }

        if($request->flag){
            $record->uploadFlag($request->flag);
        }

        return $record;
    }

    public static function prepare($request, $identifier = 'id')
    {
        $record = new static;

        if ($request->has($identifier) && $request->get($identifier) != null && $request->get($identifier) != 0) {
            $record = static::find($request->get($identifier));
        }
        
        return $record;
    }
    /* END SAVE DATA */

    public function uploadFile($files = [], $revisi = 'Lampiran 1')
    {
        if($files && !is_null($files) && isset($files)){
            if($files && is_object($files)){
                HelperPhoto::upload(
                    isset($files) ? $files : [],
                    $this->filesMorphClass(),
                    $this->id,
                    $revisi,
                    null
                );
            }else{
                if(!is_string($files)){
                    if($files && count($files) > 0){
                        foreach($files as $key => $file){
                            if(!is_null($file) && isset($file)){
                                if(is_object($file)){
                                    HelperPhoto::upload(
                                        $file,
                                        $this->filesMorphClass(),
                                        $this->id,
                                        $revisi,
                                        null
                                    );
                                }else{
                                    $this->uploadFile($file, $revisi = 'Lampiran 1');  
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function deleteFile($data){
        if($data){
            if(count($data) > 0){
                File::whereIn('id',$data)->delete();
            }
        }
    }

    public function uploadFlag($data = []){
        if(isset($data['idDel'])){
            MasterTag::destroy($data['idDel']);
        }
        if(isset($data['title'])){
            if(count($data['title']) > 0){
                foreach($data['title'] as $k => $value){
                    if(isset($data['id'])){
                        if(isset($data['id'][$k])){
                            MasterTag::find($data['id'][$k])->update([
                                'title' => $value,
                            ]);
                        }else{
                            MasterTag::create([
                                'title' => $value,
                                'target_type' =>  $this->filesMorphClass(),
                                'target_id' => $this->id,
                            ]);

                        }
                    }else{
                        MasterTag::create([
                            'title' => $value,
                            'target_type' =>  $this->filesMorphClass(),
                            'target_id' => $this->id,
                        ]);

                    }
                }
            }
        }
    }
}
