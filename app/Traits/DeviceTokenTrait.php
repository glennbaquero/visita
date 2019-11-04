<?php

trait DeviceTokenTrait
{
    public function device_tokens() {
        return $this->morphMany(DeviceToken::class, 'user');
    }
}