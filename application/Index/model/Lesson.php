<?php
/**
 * Created by PhpStorm.
 * User: www44
 * Date: 2019/2/1
 * Time: 20:53
 */

namespace app\index\model;


use think\Db;
use think\Model;

class Lesson extends Model
{
    protected $pk = 'id';
    protected $autoWriteTimestamp=true;
    protected $createTime='create_time';
    protected $updateTime='update_time';

    public function search($params,$pageSize = 12){
        $where = [];
        $list = Db::name('lesson')->alias('t')->order('id desc');

        if(isset($params['search_key'])){
            $where['t.name'] = array('like','%'.$params['search_key'].'%');
        }

        $list = $list->where($where);
        $list = $list->paginate($pageSize)->each(function ($item,$key){
            $teachers = Teacher::where('id','in',$item['teacher_ids'])->column('name');
            $item['teachers_name'] = implode(',',$teachers);
            return $item;
        });

        return $list;
    }
}