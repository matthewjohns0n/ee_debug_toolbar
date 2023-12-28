<?php

namespace Mithra62\DebugToolbar\PerfAlerts\Extensions;

use ExpressionEngine\Service\Addon\Controllers\Extension\AbstractRoute;
use Mithra62\DebugToolbar\Services\ToolbarService;

abstract class AbstractHook extends AbstractRoute
{
    /**
     * @var ToolbarService|mixed
     */
    protected ToolbarService $toolbar;

    public function __construct($settings = '')
    {
        ee()->lang->loadfile('eedt_memory_history');
        $this->toolbar = ee('ee_debug_toolbar:ToolbarService');
    }
}