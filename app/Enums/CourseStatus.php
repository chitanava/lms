<?php

namespace App\Enums;

enum CourseStatus: string
{
  case NotStarted = 'Not started';
  case Active = 'Active';
  case Ended = 'Ended';

  public function getLabel(): string
  {
    return match ($this) {
      self::NotStarted => __('status.not_started'),
      self::Active => __('status.active'),
      self::Ended => __('status.ended'),
    };
  }

  public function getColor(): string
  {
    return match($this){
      self::NotStarted => 'gray',
      self::Active => 'success',
      self::Ended => 'danger',
    };
  }
}
