<?php

namespace common\components;

use yii\filters\AccessRule as YiiAccessRule;

class AccessRule extends YiiAccessRule
{
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }

        if ($user->isGuest) {
            return false;
        }

        foreach ($this->roles as $role) {
            if ($user->identity->role === $role) {
                return true;
            }
        }

        return false;
    }
}
