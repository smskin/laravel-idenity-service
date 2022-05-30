<?php

namespace SMSkin\IdentityService\Modules\Core;

use Illuminate\Queue\SerializesModels;

abstract class BaseRepresenter
{
    use SerializesModels;

    abstract public function toArray(): array;
}
