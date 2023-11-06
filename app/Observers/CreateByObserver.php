<?php

namespace App\Observers;

class CreateByObserver
{
    /**
     * @var int|string|null
     */
    private $user_id;

    public function __construct()
    {
        $this->user_id = (!is_null(\auth())) ? \auth()->id() : null;
    }

    public function creating($model)
    {
        $model->created_by = $this->user_id;
    }

    public function created($model)
    {
        $model->created_by = $this->user_id;
    }

}
