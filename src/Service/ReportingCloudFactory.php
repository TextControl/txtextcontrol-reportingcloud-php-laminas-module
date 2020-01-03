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
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Service;

use Interop\Container\ContainerInterface;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;
use Laminas\ServiceManager\Factory\FactoryInterface;

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
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): ReportingCloud
    {
        $config = $container->get('Config');

        $credentials = $this->getCredentials($config);

        return new ReportingCloud($credentials);
    }

    /**
     * Return required credentials to use the Reporting Cloud Web API
     *
     * @param array $config
     *
     * @return array
     */
    protected function getCredentials(array $config): array
    {
        $ret = null;

        $source = '/vendor/textcontrol/txtextcontrol-reportingcloud-laminas-module/config/reportingcloud.local.php.dist';
        $dest   = '/config/autoload/reportingcloud.local.php';

        $help = "Copy '{$source}' to '{$dest}' in your Laminas application, ";
        $help .= "then add your ReportingCloud credentials to that file.";

        if (!array_key_exists('reportingcloud', $config)) {
            $message = "The key 'reportingcloud' has not been specified in your application's configuration file. ";
            $message .= $help;
            throw new InvalidArgumentException($message);
        }

        if (!array_key_exists('credentials', $config['reportingcloud'])) {
            $message = "The key 'credentials' has not been specified under the key 'reportingcloud' ";
            $message .= "in your application's configuration file. ";
            $message .= $help;
            throw new InvalidArgumentException($message);
        }

        $c = $config['reportingcloud']['credentials'];

        if (isset($c['api_key']) && !empty($c['api_key'])) {
            $ret = [
                'api_key' => $c['api_key'],
            ];
        }

        if (isset($c['username']) && !empty($c['username']) && isset($c['password']) && !empty($c['password'])) {
            $ret = [
                'username' => $c['username'],
                'password' => $c['password'],
            ];
        }

        if (null === $ret) {
            $message = "Neither the key 'api_key', nor the keys 'username' and 'password' have been specified under ";
            $message .= "the key 'reportingcloud', sub-key 'credentials' in your application's configuration file. ";
            $message .= $help;
            throw new InvalidArgumentException($message);
        }

        return $ret;
    }
}
