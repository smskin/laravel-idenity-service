<?php

namespace SMSkin\IdentityService\Modules\OAuth\Models;

use Illuminate\Contracts\Support\Arrayable;

class Callback implements Arrayable
{
    public string $url;
    public string $key;

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'key' => $this->key
        ];
    }

    public function fromArray(array $data): self
    {
        $this->url = $data['url'];
        $this->key = $data['key'];
        return $this;
    }

    /**
     * @param string $url
     * @return Callback
     */
    public function setUrl(string $url): Callback
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $key
     * @return Callback
     */
    public function setKey(string $key): Callback
    {
        $this->key = $key;
        return $this;
    }
}
