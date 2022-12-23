<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Languages_model extends Model
{
    public static $tbl = 'languages';
    protected $table = 'languages';
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
				$qu->orWhere(self::$tbl. '.name_english', 'like', '%'.$search.'%');
				$qu->orWhere(self::$tbl. '.name_kannada', 'like', '%'.$search.'%');
			});
        }

        if (isset($data['name_english'])) {
            $query->where(self::$tbl. '.name_english', $data['name_english']);
        }

        if (isset($data['name_kannada'])) {
            $query->where(self::$tbl. '.name_kannada', $data['name_kannada']);
        }

        if (isset($data['deleted_at'])) {
            $query->where(self::$tbl. '.deleted_at', $data['deleted_at']);
        }

        if (isset($data['deleted_at_null'])) {
            $query->whereNull(self::$tbl. '.deleted_at');
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

        if (isset($data['name_english'])) {
            $modelData['name_english'] = $data['name_english'];
        }
        
        if (isset($data['name_kannada'])) {
            $modelData['name_kannada'] = $data['name_kannada'];
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
