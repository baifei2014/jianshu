<?php
namespace common\helpers;

use yii\behaviors\TimestampBehavior;

class TimestampBehaviorHelp extends TimestampBehavior
{
    public $createdAtAttribute = 'create_time';

    public $updatedAtAttribute = 'update_time';
}