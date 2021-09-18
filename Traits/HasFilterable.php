<?php
namespace Modules\Core\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

trait HasFilterable
{
    public function scopeFilterable($query, $request, array $definition = [], $user_id = null)
    {
        if($user_id) {
            $query->where('user_id', $user_id);
        }

        if($request->filled('filter_by')) {
            if(count($definition) > 0 && $request->filled('filter_val')) {
                $query->where($definition[$request->filter_by], $request->filter_val);
            }
        }

        if($request->filled('from') && $request->filled('to')) {
            $from = Carbon::createFromFormat('d-m-Y', $request->from)->startOfDay();
            $to = Carbon::createFromFormat('d-m-Y', $request->to)->endOfDay();
            $query->whereBetween('created_at', [$from, $to]);
        }

        if($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    public function scopeSearchable($query, $request, array $definition = [])
    {
        if($request->filled('search')) {
            if(count($definition) > 0) {
                foreach($definition as $index => $value) {
                    if($index === 0)
                        $query->where($value, 'LIKE', '%'.$request->search.'%');
                    else
                        $query->orWhere($value, 'LIKE', '%'.$request->search.'%');
                }
            }
        }

        return $query;
    }

    public function scopeSortable($query, $request)
    {
        if($request->filled('sort_by')) {
            if($request->sort_by === 'latest') {
                $query->latest();
            } else if($request->sort_by === 'oldest') {
                $query->oldest();
            } else if($request->sort_by === 'az' || $request->sort_by === 'za') {
                $query->orderBy('name', $request->sort_by === 'az' ? 'asc' : 'desc');
            }else {
                $sort_dir = $request->filled('sort_dir') ?? 'desc';

                $query->orderBy($request->sort_by, 'desc');
            }
        } else {
            $query->latest();
        }

        return $query;
    }
}
