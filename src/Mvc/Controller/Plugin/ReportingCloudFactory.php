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

namespace TxTextControl\ReportingCloud\Mvc\Controller\Plugin;

use Interop\Container\ContainerInterface;
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
    // @phpstan-ignore-next-line
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): ReportingCloud {

        $reportingCloud = $container->get('ReportingCloud');

        return new ReportingCloud($reportingCloud);
    }
}
