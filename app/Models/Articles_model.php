<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articles_model extends Model
{
    use SoftDeletes;
    public static $tbl = 'articles';
    protected $table = 'articles';
    protected $dates = ['deleted_at'];

    public function getData($data = [], $single = false, $num_rows = false) {
        $query = DB::table(self::$tbl);
        if ($num_rows) {
			$query->select(
				DB::raw("COUNT(".self::$tbl.".id) as totalRecord")
			);
		} else {
            $base = env('APP_URL').Config('constant.UPLOAD_URL');
            $query->select([
                self::$tbl. ".*",                
                DB::raw("CONCAT('" . $base . "', " . self::$tbl . ".image_path	) as image_path	", FALSE),
                DB::raw("CONCAT('" . env('APP_URL').env('THUMBURL') . "', " . self::$tbl . ".image_path	) as thumbImage", FALSE),
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
				$qu->orWhere(self::$tbl. '.author_name', 'like', '%'.$search.'%');
				$qu->orWhere(self::$tbl. '.body_text', 'like', '%'.$search.'%');
				$qu->orWhere(self::$tbl. '.title', 'like', '%'.$search.'%');
				$qu->orWhere(self::$tbl. '.publish_date', 'like', '%'.$search.'%');
                
			});
        }

        if (isset($data['visibility_status'])) {
            if (is_array($data['visibility_status'])) {
                $query->whereIn(self::$tbl . '.visibility_status', $data['visibility_status']);
            } else {
                $query->where(self::$tbl . '.visibility_status', $data['visibility_status']);
            }
        }

        if (isset($data['publish_date'])) {
            $query->where(self::$tbl. '.publish_date', $data['publish_date']);
        }

        if (isset($data['groupByYear'])) {
            // DB::raw('YEAR(created_at)')
            $query->where(DB::raw('YEAR('.self::$tbl.'.publish_date)'), $data['groupByYear']);
        }

        if (isset($data['groupByMonth'])) {
            $query->where(DB::raw('MONTH('.self::$tbl.'.publish_date)'), $data['groupByMonth']);
        }

        if (isset($data['author_name'])) {
            $query->where(self::$tbl. '.author_name', $data['author_name']);
        }

        if (isset($data['meta_title'])) {
            $query->where(self::$tbl. '.meta_title', $data['meta_title']);
        }

        if (isset($data['meta_keyword'])) {
            $query->where(self::$tbl. '.meta_keyword', $data['meta_keyword']);
        }

        if (isset($data['meta_description'])) {
            $query->where(self::$tbl. '.meta_description', $data['meta_description']);
        }

        if (isset($data['slug'])) {
            $query->where(self::$tbl. '.slug', $data['slug']);
        }

        if (isset($data['article_categories_id'])) {
            $query->where(self::$tbl. '.article_categories_id', $data['article_categories_id']);
        }

        if (isset($data['languages_id'])) {
            $query->where(self::$tbl. '.languages_id', $data['languages_id']);
        }

        if (isset($data['image_path'])) {
            $query->where(self::$tbl. '.image_path', $data['image_path']);
        }

        if (isset($data['title'])) {
            $query->where(self::$tbl. '.title', $data['title']);
        }

        if (isset($data['body_text'])) {
            $query->where(self::$tbl. '.body_text', $data['body_text']);
        }

        if (isset($data['created_by_user_id'])) {
            $query->where(self::$tbl. '.created_by_user_id', $data['created_by_user_id']);
        }

        if (isset($data['updated_by_user_id'])) {
            $query->where(self::$tbl. '.updated_by_user_id', $data['updated_by_user_id']);
        }

        if (isset($data['created_at'])) {
            $query->where(self::$tbl. '.created_at', $data['created_at']);
        }

        if (isset($data['updated_at'])) {
            $query->where(self::$tbl. '.updated_at', $data['updated_at']);
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
            } else {
                // $query->limit(10);
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

        if (isset($data['visibility_status'])) {
            $modelData['visibility_status'] = $data['visibility_status'];
        }
        
        if (isset($data['publish_date'])) {
            $modelData['publish_date'] = $data['publish_date'];
        }

        if (isset($data['author_name'])) {
            $modelData['author_name'] = $data['author_name'];
        }

        if (isset($data['meta_title'])) {
            $modelData['meta_title'] = $data['meta_title'];
        }


        if (isset($data['title'])) {
            $modelData['title'] = $data['title'];
        }
        
        if (isset($data['meta_keyword'])) {
            $modelData['meta_keyword'] = $data['meta_keyword'];
        }

        if (isset($data['meta_description'])) {
            $modelData['meta_description'] = $data['meta_description'];
        }

        if (isset($data['slug'])) {
            $modelData['slug'] = $data['slug'];
        }

        if (isset($data['article_categories_id'])) {
            $modelData['article_categories_id'] = $data['article_categories_id'];
        }

        if (isset($data['languages_id'])) {
            $modelData['languages_id'] = $data['languages_id'];
        }

        if (isset($data['body_text'])) {
            $modelData['body_text'] = $data['body_text'];
        }

        if (isset($data['created_by_user_id'])) {
            $modelData['created_by_user_id'] = $data['created_by_user_id'];
        }

        if (isset($data['updated_by_user_id'])) {
            $modelData['updated_by_user_id'] = $data['updated_by_user_id'];
        }

        if (isset($data['image_path'])) {
            $modelData['image_path'] = ucwords($data['image_path']);
        }

        if (isset($data['created_at'])) {
            $modelData['created_at'] = $data['created_at'];
        }

        if (isset($data['updated_at'])) {
            $modelData['updated_at'] = $data['updated_at'];
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
