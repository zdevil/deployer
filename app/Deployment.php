<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deployment extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'deployments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['committer', 'commit', 'project_id', 'status'];

    public function getDates()
    {
        return ['created_at', 'started_at', 'finished_at', 'updated_at'];
    }
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function isRunning()
    {
        return ($this->status == 'Deploying');
    }

    public function steps()
    {
        return $this->hasMany('App\DeployStep');
    }

    public function runtime()
    {
        if (!$this->finished_at) {
            return false;
        }

        return $this->started_at->diffInSeconds($this->finished_at);
    }
}
