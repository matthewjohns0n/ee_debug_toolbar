<?php

use ExpressionEngine\Service\Migration\Migration;

class CreateExtHookEeDebugToolbarInitSettingsForAddonEedtPerfAlerts extends Migration
{
    /**
     * Execute the migration
     * @return void
     */
    public function up()
    {
        $addon = ee('Addon')->get('eedt_perf_alerts');

        $ext = [
            'class' => $addon->getExtensionClass(),
            'method' => 'ee_debug_toolbar_init_settings',
            'hook' => 'ee_debug_toolbar_init_settings',
            'settings' => serialize([]),
            'priority' => 10,
            'version' => $addon->getVersion(),
            'enabled' => 'y'
        ];

        // If we didnt find a matching Extension, lets just insert it
        ee('Model')->make('Extension', $ext)->save();
    }

    /**
     * Rollback the migration
     * @return void
     */
    public function down()
    {
        $addon = ee('Addon')->get('eedt_perf_alerts');

        ee('Model')->get('Extension')
            ->filter('class', $addon->getExtensionClass())
            ->delete();
    }
}
