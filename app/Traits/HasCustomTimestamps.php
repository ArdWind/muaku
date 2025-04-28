<?php

namespace App\Traits;

trait HasCustomTimestamps
{
  public function getCreatedAtColumn()
  {
    return 'CreatedDate'; // Nama kolom created yang kamu pakai
  }

  public function getUpdatedAtColumn()
  {
    return 'LastUpdatedDate'; // Nama kolom updated yang kamu pakai
  }
}
