<?php
namespace App\Traits;

trait Trans
{
    public function getTransNameAttribute()
    {
        if($this->name) {
            return json_decode($this->name, true)[app()->currentLocale()];
        }

        return $this->name;
    }

    public function getNameEnAttribute()
    {
        if($this->name) {
            return json_decode($this->name, true)['en'];
        }

        return $this->name;
    }

    public function getNameArAttribute()
    {
        if($this->name) {
            return json_decode($this->name, true)['ar'];
        }

        return $this->name;
    }

    // protected function nameAr(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => json_decode($this->name, true)['ar']
    //     );
    // }

    public function getTransContentAttribute()
    {
        if($this->content) {
            return json_decode($this->content, true)[app()->currentLocale()];
        }

        return $this->content;
    }

    public function getContentEnAttribute()
    {
        if($this->content) {
            return json_decode($this->content, true)['en'];
        }

        return $this->content;
    }

    public function getContentArAttribute()
    {
        if($this->content) {
            return json_decode($this->content, true)['ar'];
        }

        return $this->content;
    }
}
