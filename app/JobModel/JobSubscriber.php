<?php
namespace App\JobModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscriber
 *
 */
class JobSubscriber extends Model
{

    /**
     * Fillables for the database
     *
     * @access protected
     * @var    array $fillable
     */
    protected $fillable = array('name', 'email');

    /**
     * Save subscriber
     *
     * @param mixed $request $req->attr
     *
     *
     * @return relation
     */
    public function saveSubscriber($request)
    {
        $this->name = $request->user_name;
        $this->email = $request->email;
        $this->save();
    }

}
