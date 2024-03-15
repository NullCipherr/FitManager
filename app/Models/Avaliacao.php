<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Avaliacao extends Model
{
    use HasFactory, SoftDeletes,Notifiable;

    protected $table = 'avaliacoes';
    protected $guarded = [];
    protected $fillable = [
        'descr',
        'dateA',

    ];

    public function getAlunoName($id)
    {
        $s = DB::table('alunos')
            ->where('id', '=', $id)
            ->get('name')
            ->pluck('name')
            ->toArray();

        return implode(" ", $s);
    }
    // public function getProfessorName($id)
    // {
    //     $s = DB::table('professores')
    //         ->where('id', '=', $id)
    //         ->get('nome_fan')
    //         ->pluck('nome_fan')
    //         ->toArray();

    //     return implode(" ", $s);
    // }



    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }


    public function getNameAttribute()
    {
        return $this->descr;
    }

    public function scopeOrderByDescr($query)
    {
        $query->orderBy('descr');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('descr', 'like', '%'.$search.'%')
                    ->orWhere('nota', 'like', '%'.$search.'%');

            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
