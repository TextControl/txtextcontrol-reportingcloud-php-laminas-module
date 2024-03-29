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
 * @copyright © 2022 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Mvc\Controller\Plugin;

use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use TxTextControl\ReportingCloud\ReportingCloud as TxTextControlReportingCloudReportingCloud;

/**
 * Class ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloud extends AbstractPlugin
{
    /**
     * @var TxTextControlReportingCloudReportingCloud
     */
    protected TxTextControlReportingCloudReportingCloud $reportingCloud;

    /**
     * ReportingCloud constructor
     *
     * @param TxTextControlReportingCloudReportingCloud $reportingCloud
     */
    public function __construct(TxTextControlReportingCloudReportingCloud $reportingCloud)
    {
        $this->reportingCloud = $reportingCloud;
    }

    /**
     * @return TxTextControlReportingCloudReportingCloud
     */
    public function __invoke(): TxTextControlReportingCloudReportingCloud
    {
        return $this->reportingCloud;
    }
}
