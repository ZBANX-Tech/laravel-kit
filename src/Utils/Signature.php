<?php


namespace Zbanx\Kit\Utils;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Zbanx\Kit\Exceptions\SignatureException;

class Signature
{
    private $appId, $appSecret;

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }


    /**
     * 生成签名
     * @param $params
     * @param null $expires
     * @return string
     */
    public function sign($params, $expires = null): string
    {
        $params['_app_id'] = $this->appId;
        if ($expires != null) {
            $params['_expires'] = $expires;
        }
        $params['signature'] = $this->getSignature($params);

        return '?' . http_build_query($params, null, '&');
    }


    /**
     * 检查签名
     * @param $params
     * @return bool
     * @throws SignatureException
     */
    public function checkSign($params): bool
    {
        $signature = Arr::pull($params, 'signature');
        $expires = Arr::get($params, '_expires', false);
        if ($expires !== false && $expires < time()) {
            throw new SignatureException('Signature Expires');
        }
        $_signature = $this->getSignature($params);
        return $signature == $_signature;
    }

    /**
     * 获取签名
     * @param $params
     * @return string
     */
    private function getSignature($params): string
    {
        $params = Arr::where($params, function ($val, $key) {
            return Str::startsWith($key, '_');
        });
        ksort($params);
        $content = http_build_query($params, null, '') . '_app_secret=' . $this->appSecret;
        $signature = hash_hmac('sha1', $content, $this->appSecret, true);
        return md5(base64_encode($signature));
    }
}
