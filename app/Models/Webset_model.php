<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Webset_model extends Model
{
    public static $tbl = 'webset';
    protected $table = 'webset';
    public function getData($data = [], $single = false, $num_rows = false) {
        $query = DB::table(self::$tbl);
        if ($num_rows) {
			$query->select(
				DB::raw("COUNT(".self::$tbl.".id) as totalRecord")
			);
		} else {
            $query->select([
                self::$tbl. ".*",
            ]);
        }

        if (isset($data['id']) && !empty($data['id'])) {
			if (is_array($data['id'])) {
				$query->whereIn(self::$tbl. '.id', $data['id']);
			} else {
				$query->Where(self::$tbl. '.id', $data['id']);
			}
        }

        if (isset($data['search']) && !empty($data['search'])) {
            $search = trim($data['search']);
            $query->where(function($qu) use ($search){
				$qu->orWhere(self::$tbl. '.key_name', 'like', '%'.$search.'%');
				$qu->orWhere(self::$tbl. '.value', 'like', '%'.$search.'%');
				$qu->orWhere(self::$tbl. '.description', 'like', '%'.$search.'%');
			});
        }

        if (isset($data['key_name'])) {
            $query->where(self::$tbl. '.key_name', $data['key_name']);
        }

        if (isset($data['value'])) {
            $query->where(self::$tbl. '.value', $data['value']);
        }

        if (isset($data['description'])) {
            $query->where(self::$tbl. '.description', $data['description']);
        }

        if (!$num_rows) {
            if (isset($data['limit']) && isset($data['offset'])) {
                $query->limit($data['limit']);
                $query->offset($data['offset']);
            } elseif (isset($data['limit']) && !empty($data['limit'])) {
                $query->limit($data['limit']);
            }
        }

        if (isset($data['orderby']) && !empty($data['orderby'])) {
			$query->orderBy(self::$tbl. '.'.$data['orderby'], (isset($data['orderstate']) && !empty($data['orderstate']) ? $data['orderstate'] : 'DESC'));
		} else {
			$query->orderBy(self::$tbl. '.id', 'DESC');
		}

        if ($num_rows) {
			$row = $query->first();
            return isset($row->totalRecord)?$row->totalRecord:"0";
		}

		if ($single) {
			return $query->first();
		} elseif (isset($data['id']) && !empty($data['id']) && !is_array($data['id'])) {
            return $query->first();
        }
		
		return $query->get()->toArray();
    }

    public function setData($data, $id = 0) {
        if (empty($data)) {
            return false;
        }
        $modelData = array();

        if (isset($data['key_name'])) {
            $modelData['key_name'] = $data['key_name'];
        }
        
        if (isset($data['value'])) {
            $modelData['value'] = $data['value'];
        }
        
        if (isset($data['description'])) {
            $modelData['description'] = $data['description'];
        }

        if (empty($modelData)) {
            return false;
        }

        $query = DB::table(self::$tbl);
        if (!empty($id)) {
			if(is_array($id)){
				$query->whereIn('id', $id);
				$query->update($modelData);
			}else{
				$query->where('id', $id);
				$query->update($modelData);
			}
		} else {
			$id = $query->insertGetId($modelData);
		}

        return $id;
    }

}
