<?php
declare(strict_types=1);

/**
 * ReportingCloud Laminas Module
 *
 * Laminas Module for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/JexF4 for the canonical source repository
 * @license   https://git.io/JexFB
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Class ReportingCloudFactory
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloudFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return ReportingCloud
     */
    // @phpstan-ignore-next-line
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): ReportingCloud{

        $config = $container->get('Config');

        $credentials = $this->getCredentials($config);

        return new ReportingCloud($credentials);
    }

    /**
     * Return required credentials to use the Reporting Cloud Web API
     *
     * @param array<string, array> $config
     *
     * @return array<string, string>
     */
    protected function getCredentials(array $config): array
    {
        if (!array_key_exists('reportingcloud', $config)) {
            $message = "The key 'reportingcloud' has not been specified in your application's configuration file. ";
            $message .= $this->getHelp();
            throw new InvalidArgumentException($message);
        }

        if (!array_key_exists('credentials', $config['reportingcloud'])) {
            $message = "The key 'credentials' has not been specified under the key 'reportingcloud' ";
            $message .= "in your application's configuration file. ";
            $message .= $this->getHelp();
            throw new InvalidArgumentException($message);
        }

        $credentials = $config['reportingcloud']['credentials'];

        if (array_key_exists('api_key', $credentials)) {
            $apiKey = $credentials['api_key'];
            if (is_string($apiKey) && strlen($apiKey) > 0) {
                return [
                    'api_key' => $apiKey,
                ];
            }
        }

        if (array_key_exists('username', $credentials) && array_key_exists('password', $credentials)) {
            $username = $credentials['username'];
            $password = $credentials['password'];
            if (is_string($username) && strlen($username) > 0 && is_string($password) && strlen($password) > 0) {
                return [
                    'username' => $username,
                    'password' => $password,
                ];
            }
        }

        $message = "Either the key 'api_key', or the keys 'username' and 'password' have not been specified under ";
        $message .= "the key 'reportingcloud', sub-key 'credentials' in your application's configuration file. ";
        $message .= $this->getHelp();
        throw new InvalidArgumentException($message);
    }

    /**
     * Return help text, used as assistance in exception message
     *
     * @return string
     */
    protected function getHelp(): string
    {
        $path   = '/vendor/textcontrol/txtextcontrol-reportingcloud-laminas-module';
        $source = "{$path}/config/reportingcloud.local.php.dist";
        $dest   = '/config/autoload/reportingcloud.local.php';

        $ret = "Copy '{$source}' to '{$dest}' in your Laminas application, ";
        $ret .= "then add your ReportingCloud credentials to that file.";

        return $ret;
    }
}
