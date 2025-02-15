<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as SpatieLogsActivity;

trait LogsActivity
{
    use SpatieLogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName(class_basename($this))
            ->logUnguarded()
            ->setDescriptionForEvent(function(string $eventName) {
                return match($eventName) {
                    'created' => 'criado',
                    'updated' => 'atualizado',
                    'deleted' => 'excluído',
                    default => $eventName
                };
            });
    }

    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            if ($user = Auth::user()) {
                activity()
                    ->performedOn($model)
                    ->causedBy($user)
                    ->withProperties([
                        'attributes' => collect($model->attributesToArray())
                            ->only(['id', 'nome', 'name'])
                            ->toArray()
                    ])
                    ->event('created')
                    ->log('criado');
            }
        });

        static::updated(function ($model) {
            if ($user = Auth::user()) {
                $changes = $model->getDirty();
                $original = collect($model->getOriginal())
                    ->only(['id', 'nome', 'name'])
                    ->toArray();
                $new = collect($model->attributesToArray())
                    ->only(['id', 'nome', 'name'])
                    ->toArray();

                if (!empty(array_intersect_key($changes, array_flip(['nome', 'name'])))) {
                    activity()
                        ->performedOn($model)
                        ->causedBy($user)
                        ->withProperties([
                            'old' => $original,
                            'new' => $new
                        ])
                        ->event('updated')
                        ->log('atualizado');
                }
            }
        });

        static::deleting(function ($model) {
            if ($user = Auth::user()) {
                activity()
                    ->performedOn($model)
                    ->causedBy($user)
                    ->withProperties([
                        'old' => collect($model->attributesToArray())
                            ->only(['id', 'nome', 'name'])
                            ->toArray()
                    ])
                    ->event('deleted')
                    ->log('excluído');
            }
        });
    }
}
